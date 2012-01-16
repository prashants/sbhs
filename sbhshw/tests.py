"""
This file demonstrates two different styles of tests (one doctest and one
unittest). These will both pass when you run "manage.py test".

Replace these with more appropriate tests for your application.
"""

from django.test import TestCase
from django.test.client import Client

from sbhshw.models import SlotBooking, Account

class SimpleTest(TestCase):
    def setUp(self):
        # every test needs a client
        self.client = Client()

    def test_checkconnection(self):
        # test connection to server
        response = self.client.get('/checkconnection')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, 'TESTOK')

    def test_startexp(self):
        ## test GET request to URL not allowed
        response = self.client.get('/startexp')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, 'Please use the SBHS Client')

        ## test POST request to URL without rollno and password
        response = self.client.post('/startexp')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')

        ## test POST request to URL without rollno
        response = self.client.post('/startexp', {'password' : '1'})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')

        ## test POST request to URL without password
        response = self.client.post('/startexp', {'rollno' : '1'})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')

        testuser1 = Account.objects.create(acc_id=1, rollno='testuser1', password='41da76f0fc3ec62a6939e634bfb6a342',
                emailid='testuser1@gmail.com', name='Test User 1', mid=0, regdate='01.01.2012', approved='Approved')

        ## test POST request to URL with valid rollno and password without a slot
        response = self.client.post('/startexp', {'rollno' : 'testuser1', 'password' : 'testuser1'})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "No valid slot found"]')

        testslot1 = SlotBooking.objects.create(slot_id=1, rollno='testuser1', slot_date='13.01.2012', start_time='2.00', end_time='3.00'
                time=)
