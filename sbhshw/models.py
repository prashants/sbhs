from django.db import models

# Create your models here.

class SlotBooking(models.Model):
    slot_id = models.IntegerField(primary_key=True)
    rollno = models.CharField(max_length=30)
    slot_date = models.CharField(max_length=90)
    start_time = models.CharField(max_length=33)
    end_time = models.CharField(max_length=30)
    time = models.IntegerField()
    mid = models.CharField(max_length=30)
    rno = models.CharField(max_length=180)
    is_busy = models.IntegerField()

    class Meta:
        db_table = u'slot_booking'

