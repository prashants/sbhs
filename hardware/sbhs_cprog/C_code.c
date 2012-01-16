
#include <avr/io.h>
#include<util/delay.h>
#include <avr/interrupt.h>
//#include <iom16.h>

//LCD Variables---------------------------------------------
int lcd_data1[16]={'T','E','M','P',0X20,'F','A','N',0X20,'H','E','A',0X20,'M','I','D' };
int lcd_data2[16]={0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20,0X20};
float val[15] = {0,0,0,0,0,0,0,0,0,0,0,0,0,0,0}; 

//Serial ISR variables--------------------------------------
int value=0;
int temperature_c = 0;
int test1 = 0;
int temp_val = 0;
unsigned char next_byte_light = 0;
unsigned char next_byte_fan = 0; 
unsigned char temp_upper_byte_send;
unsigned char temp_lower_byte_send;
unsigned char ser_data = 0;
unsigned char light = 0;
unsigned char fan = 0;
int temperature_c_upper_byte = 0; 
int temperature_c_lower_byte = 0;
int temperature = 0; 
int r=1;
int lightdisp;
int fandisp;

int mid = 15;
//Initializing microcontroller ports
void port_init(void)
{
	PORTA = 0x00;
	DDRA  = 0x00;
	PORTC = 0x00; //m103 output only
	DDRC  = 0xFF;
	PORTD = 0x7F; //-----------7F
	DDRD  = 0xF0;
}



//Initializing ADC
void adc_init(void)
{
	ADCSRA = 0x00; //disable adc
	ADMUX = 0x00; //select adc input 0
	ACSR  = 0x80;
	ADCSRA = 0xEF; //---------------0xEE----------0xEF
	SREG|=0x80;
}


//ADC conversion complete interrupt subroutine
ISR(ADC_vect)
{
	//conversion complete, read value (int) using...
	temperature_c=ADCL;            //Read 8 low bits first (important)
	temperature_c|=(int)ADCH << 8; //read 2 high bits and shift into top byte
	value = temperature_c;
	MCUCR = 0x00;
}


//Timer/Counter1 initialization for PWM generation
void timer1_init(void)
{
	TCCR1B=0x00;//stop timer during configuration
	TCCR1A=0xA1;
	OCR1AH=0x00;
	OCR1AL=0x00;//setting heater 0
	OCR1BH=0x00;
	OCR1BL=0xFC;//setting fan full
	TCCR1B=0x0B;//start timer
}


//USART initialization for serial communication
void uart0_init(void)
{
	UCSRB = 0x00; //disable while setting baud rate
	UCSRA = 0x00;
	UCSRC = 0x86;
	UBRRL = 0x33; //set baud rate lo----------0x19--------0x33
	UBRRH = 0x00; //set baud rate hi
	UCSRB = 0x98; //0x98--------------
}


//USART receive complete interrupt subroutine
ISR(USART_RXC_vect)

{
	//uart has received a character in UDR

	ser_data = UDR;

	if(ser_data < 252)
	{
		if (next_byte_light == 1)
		{
			lightdisp = ser_data;
			light = ((ser_data*40)/100);
			if (light > 40)
			{
				light = 40;
			}
			OCR1AL = light; //heating element input
			next_byte_light = 0;
		}

		if (next_byte_fan == 1)
		{
			fandisp = ser_data;
			fan = ((ser_data*251)/100);
			OCR1BL = fan; //fan speed input
			next_byte_fan = 0;
		}
	}

	if (ser_data == 254) //command for heater ---------------
	{
		next_byte_light = 1;
		next_byte_fan = 0;
	}

	if (ser_data == 253) //command for fan -------------
	{
		next_byte_light = 0;
		next_byte_fan = 1;
	}

	if (ser_data == 252)//command to retrieve machine ID
	{
		UDR = mid;
	}


	if(ser_data == 255)
	{
		temperature = test1;
		temperature_c_lower_byte = temperature%10;
		temperature_c_upper_byte = temperature/10;
		temp_upper_byte_send = (unsigned char) temperature_c_upper_byte;
		temp_lower_byte_send = (unsigned char) temperature_c_lower_byte;
		UDR = temp_upper_byte_send;
		UDR = temp_lower_byte_send;
		UDR = temp_upper_byte_send;
		UDR = temp_lower_byte_send;
		UDR = temp_upper_byte_send;
		UDR = temp_lower_byte_send;
	}



}





//Initialization routine
void init_devices(void)
{
	//stop errant interrupts until set up
	cli(); //disable all interrupts
	port_init();
	timer1_init();
	uart0_init();
	adc_init();
	GICR  = 0xC0;
	TIMSK = 0x40; //timer interrupt sources
	sei(); //re-enable interrupts
	//all peripherals are now initialised
}



void enable()// To make Enable pin high
{
	PORTC|=0x04;
} 

void disable()//To make Enable pin low
{
	PORTC&=0xFB;
}

void strobe()
{
	enable();
	disable();
}





//Routine for extarcting upper and lower nibble
unsigned char upper_lower(unsigned char *dataptr,unsigned char *lowerptr,unsigned char *upperptr)
{
	*upperptr=(*dataptr) & 0xF0;
	*lowerptr=(*dataptr) & 0x0F;
	*lowerptr=(*lowerptr<<4);
	return (0);
}

//Routine for transferring command to LCD
unsigned char data_transfer(unsigned char upper,unsigned char lower)
{ 
	PORTC&=0x0F;
	PORTC|=upper;
	strobe();

	PORTC&=0x0F;
	PORTC|=lower;
	strobe();
	_delay_ms(10);
}




//Routine for transferring data to LCD
unsigned char lcd_data_transfer(unsigned char upper,unsigned char lower)
{

	PORTC|=0x01;
	PORTC&=0x0F;

	PORTC|=upper;
	strobe();


	PORTC&=0x0F;
	PORTC|=lower;
	strobe();
	_delay_ms(10);
} 


//Switching to next line of LCD
void goto_nextline()
{ 
	unsigned char data,lower,upper;
	_delay_ms(10);

	PORTC&=0xFE;
	data=0xC0;
	upper_lower(&data,&lower,&upper);
	data_transfer(upper,lower);
} 


void refresh_lcd()
{

	unsigned char data,lower,upper;

	_delay_us(10);
	data=0x01;
	upper_lower(&data,&lower,&upper);
	data_transfer(upper,lower);
} 


//Initializing LCD
void lcd_init()
{

	unsigned char data,upper,lower;
	PORTC&=0xFB;
	PORTC&=0x0F;
	PORTC&=0xFE;

	_delay_ms(10);

	data=0x28;
	upper_lower(&data,&lower,&upper);
	data_transfer(upper,lower);

	data=0x0E;
	upper_lower(&data,&lower,&upper);
	data_transfer(upper,lower);


	data=0x06;
	upper_lower(&data,&lower,&upper);
	data_transfer(upper,lower);


} 


//Routine to print the values of Temp, Fan, Hea and Ser
void lcd_print_sensor_data (void)
{
	unsigned char data,upper,lower,i;
	unsigned char upper_lower();
	int temp1 = 0;


	val[2] = val[1];
	val[1] = 1.163*value;

	for(i=2;i<11;i++)
	{
		if(val[i]==0)
		{
			val[i] = val[1];
		}
	}

	for(i=15;i>2;i--)
	{
		val[i] = val[i-1];
	}

	temp_val = (int) val[1];

	temperature_c = temp_val;
	temp1 = temp_val;
	test1 = temp_val;
	//lcd_data2[0] = (temp1/1000) + 48;
	lcd_data2[0] = (temp1/100)%10 + 48;
	lcd_data2[1] = (temp1/10)%10 + 48;
	lcd_data2[2] = 46; //ASCII value for point(.)
	lcd_data2[3] = (temp1%10) + 48;

	//Serial data________________
	//temp1 = ser_data;
	//lcd_data2[15] = (temp1 % 10) + 48;
	//lcd_data2[14] = (temp1 / 10);
	//lcd_data2[14] = (lcd_data2[14] % 10) + 48;
	//lcd_data2[13] = (temp1 / 100) + 48;

	//MID value
	temp1 = mid;
	lcd_data2[15] = (temp1 % 10) + 48;
	lcd_data2[14] = (temp1 / 10);
	lcd_data2[14] = (lcd_data2[14] % 10) + 48;
	lcd_data2[13] = (temp1 / 100) + 48;



	//Fan________________
	temp1 = fandisp;//---------------------
	lcd_data2[7] = (temp1 % 10) + 48;
	lcd_data2[6] = (temp1 / 10);
	lcd_data2[6] = (lcd_data2[6] % 10) + 48;
	lcd_data2[5] = (temp1 / 100) + 48;

	//Heater________________
	temp1 = lightdisp; //-----------------
	lcd_data2[11] = (temp1 % 10) + 48;
	lcd_data2[10] = (temp1 / 10);
	lcd_data2[10] = (lcd_data2[10] % 10) + 48;
	lcd_data2[9] = (temp1 / 100) + 48;



	refresh_lcd();


	for(i=0; i<16; i++)

	{
		data=lcd_data1[i];
		upper_lower(&data,&lower,&upper);
		lcd_data_transfer(upper,lower);
	}
	goto_nextline();

	for(i=0; i<16; i++)

	{
		data=lcd_data2[i];
		upper_lower(&data,&lower,&upper);
		lcd_data_transfer(upper,lower);
	}

}


void main(void)
{
	init_devices();
	lcd_init();
	lcd_print_sensor_data();

	while(r=1)
	{
		refresh_lcd();
		lcd_print_sensor_data();
	}
}




