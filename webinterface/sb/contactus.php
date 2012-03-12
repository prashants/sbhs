

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
	<img src="images/iitbLogo.png"  align="left" class="special" alt="" width="100" height="100"/>
	<h1>Single Board Heater System Lab</h1>
	<h2>By <a href="http://www.iitb.ac.in/">Indian Institute of Technology, Bombay</a></h2>
</div>
	<div style="clear: both;">&nbsp;</div>
<div id="content">
	<div id="colOne">
		<div id="menu1">
			<ul>
				<li id="menu-01"><a href="index.php">SBHS Home</a></li>
				<li id="menu-02"><a href="login.php">Login to SBHS VLabs</a></li>
				<li id="menu-03"><a href="info.php">SBHS Info-Centre</a></li>
				<li id="menu-04"><a href="downloads.php">Downloads</a></li>
				<li id="menu-05"><a href="aboutus.php">About Us</a></li>
				<li id="menu-06"><a href="contactus.php">Contact Us</a></li>
			</ul>
		</div>
		<div class="margin-news">
			<h2>External Links</h2>
			<p><a href="http://www.iitb.ac.in"><strong>IIT BOMBAY</strong></a></p>
			<p><a href="http://www.vlab.co.in"><strong>VIRTUAL LABS</strong></a></p>
			<p><a href="http://www.spoken-tutorial.org"><strong>SPOKEN TUTORIALS</strong></a></p>
			<p><a href="http://www.co-learn.in"><strong>CO-LEARN</strong></a></p>
			<p><a href="http://www.cdeep.iitb.ac.in"><strong>CDEEP</strong></a></p>

		</div>
	</div>

	<div id="colTwo">
		<h2>Contact Us</h2>
		<p>
		Dr. Kannan Moudgalya: kannan@iitb.ac.in<br />
		Rakhi R : rakhi@iitb.ac.in<br />
		Rupak Rokade: rupakrokade@iitb.ac.in<br />
		SBHS (Admin) : vlabs.sbhs@gmail.com<br /></p>
		<h2>SBHS Discussion Forum</h2>
<p>
The SBHS Community has maintained a discussion forum at <a href="http://www.fossee.in/moodle">http://fossee.in/moodle</a>
</p>
		<h2>Feedback Form</h2>

				
		<p>
		<script>
		function validateform()
		{
			var x=document.forms["feedbackform"]["name"].value;
			if(x==null||x=="")
			{
				alert("Enter your Name!");
				return false;
			}
			
			var reg = /^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,4})+$/;
   			var y = document.forms["feedbackform"]["email"].value;
			if(reg.test(y) == false) {
  				alert('Invalid Email Address');
      				return false;
   			}
			
			var z=document.forms["feedbackform"]["subject"].value;
			if(z==null||z=="")
			{
				alert("Enter your Subject!");
				return false;
			}

			var p=document.forms["feedbackform"]["message"].value;
			if(p==null||p=="")
			{
				alert("Enter your Message!");
				return false;
			}

		}
		</script>
		
		<form name="feedbackform" action='contactus.php' method="post" onsubmit="return validateform()">
		<table>
		<tr>
			<td>
			Name: 
			</td>
			<td>
				<input type="text" name='name' > <br>
			</td>
			</tr>

			<tr>
			<td>
				Email: 
			</td>

			<td>
				<input type="text" name='email'> <br>
			</td>
			</tr>
			<tr>
			<td>
				Subject: 
			</td>

			<td>
				<input type="text" name='subject'> <br>
			</td>
			</tr>

			<tr>
			<td>
				Message: 
			</td>

			<td>
				<textarea name="message" cols="50" rows="4" id="message"></textarea> <br />
			</td>
			</tr>

			<tr>
				<td>
					<input type="submit" name="submit" value='Submit'>
				</td>
				<td>
				</td>
				
				</tr>
			</table>
		</form>
<?php 
			/*
			 * Coded By: Ankit Bahuguna
			 * Name of the Webpage: contactus.php
			 * The following Webpage is used for the  following:
			 * 1. Infromation about the Admins and their Email Addresses
			 * 2. Feedback form for the Naive Users to send the feedback to the admin
			 * 3. A feedback mail will be sent to the admin via the user email.
			 */

			$submit=$_POST['submit'];
			
			if($submit)
			{
				$name = strip_tags($_POST['name']);
				$email = strip_tags($_POST['email']);
				$subject = strip_tags($_POST['subject']);
				$message = strip_tags($_POST['message']);
				
				include_once 'config.inc.php';
				global $db_host, $db_user, $db_password, $db, $mailsite, $mailserver; 
				if($name && $email && $subject && message){					
				$connect=mysql_connect($db_host,$db_user,$db_password) or die("Connection failed");
				mysql_select_db("$db") or die("Not Connected to Database");
				$query = mysql_query(" INSERT INTO feedback VALUES ('', '$name', '$email', '$subject', '$message') ");
					
				$numrows=mysql_num_rows($query);

				$command ='python feedback.py '.$email;
				exec($command);
																
					echo("Thanks For Your Feedback!" );
				}else echo("Enter the Required Details!");
			}
		

?>		
		</p>
		
	</div>
	<div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
	<p>Copyright &copy; 2011 www.iitb.ac.in Designed by <a href="http://www.cdeep.iitb.ac.in"><strong>Automation Lab, CDEEP, IIT Bombay</strong></a></p>
</div>
</body>
</html>
