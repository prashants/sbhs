"""
This file demonstrates two different styles of tests (one doctest and one
unittest). These will both pass when you run "manage.py test".

Replace these with more appropriate tests for your application.
"""

from django.test import TestCase
from django.test.client import Client

class SimpleTest(TestCase):
    def setUp(self):
        # every test needs a client
        self.client = Client()

    def test_checkconnection(self):
        # test connection to server
        response = self.client.get('/sbhs/checkconnection')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, 'TESTOK')

    def test_startexp(self):
        ## test GET request to URL not allowed
        response = self.client.get('/sbhs/startexp')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, 'Please use the SBHS Client')

        ## test POST request to URL without rollno and password
        response = self.client.post('/sbhs/startexp')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')

        ## test POST request to URL without rollno
        response = self.client.post('/sbhs/startexp', {'password' : '1'})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')

        ## test POST request to URL without password
        response = self.client.post('/sbhs/startexp', {'rollno' : '1'})
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.content, '["S", "0", "Please provide username and password"]')
