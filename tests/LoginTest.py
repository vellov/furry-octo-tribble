# -*- coding: utf-8 -*-
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import NoAlertPresentException
import unittest, time, re

class LoginTest(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "http://localhost/"
        self.verificationErrors = []
        self.accept_next_alert = True
    
    def test_login(self):
        driver = self.driver
        driver.get(self.base_url + "/furry-octo-tribble/web/#/")
        self.assertEqual("Tere tulemast!", driver.find_element_by_xpath("//h3").text)
        self.assertEqual("Logi sisse, et valimistel osaleda.", driver.find_element_by_xpath("//p").text)
        
        window_before = driver.window_handles[0]
        driver.find_element_by_css_selector("button.btn.btn-primary").click()
        print window_before
        window_after = driver.window_handles[1]
        driver.switch_to_window(window_after)
        print window_after
        # ERROR: Caught exception [ERROR: Unsupported command [selectWindow | title=Facebook | ]]
        driver.find_element_by_id("email").clear()
        driver.find_element_by_id("email").send_keys("webapp.testuser2@gmail.com")
        driver.find_element_by_id("pass").clear()
        driver.find_element_by_id("pass").send_keys("veebirakendus")
        driver.find_element_by_name("login").click()
        
        driver.switch_to_window(window_before)
        # ERROR: Caught exception [ERROR: Unsupported command [selectWindow | null | ]]
        # Warning: assertTextNotPresent may require manual changes
        bodyText = driver.find_element_by_css_selector("BODY").text
        self.assertFalse("Logi sisse, et valimistel osaleda." in bodyText)
        driver.find_element_by_css_selector("button.btn.btn-primary").click()
        self.assertEqual("Tere tulemast!", driver.find_element_by_xpath("//h3").text)
        self.assertEqual("Logi sisse, et valimistel osaleda.", driver.find_element_by_xpath("//p").text)
    
    def is_element_present(self, how, what):
        try: self.driver.find_element(by=how, value=what)
        except NoSuchElementException, e: return False
        return True
    
    def is_alert_present(self):
        try: self.driver.switch_to_alert()
        except NoAlertPresentException, e: return False
        return True
    
    def close_alert_and_get_its_text(self):
        try:
            alert = self.driver.switch_to_alert()
            alert_text = alert.text
            if self.accept_next_alert:
                alert.accept()
            else:
                alert.dismiss()
            return alert_text
        finally: self.accept_next_alert = True
    
    def tearDown(self):
        self.driver.quit()
        self.assertEqual([], self.verificationErrors)

if __name__ == "__main__":
    unittest.main()
