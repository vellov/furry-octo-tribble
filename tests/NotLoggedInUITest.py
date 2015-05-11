# -*- coding: utf-8 -*-
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import NoAlertPresentException
import unittest, time, re

class NotLoggedInUITest(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "https://pacific-sea-1219.herokuapp.com/"
        self.verificationErrors = []
        self.accept_next_alert = True
    
    def test_not_logged_in_u_i(self):
        driver = self.driver
        driver.get(self.base_url + "#/")
        self.assertEqual("Tere tulemast!", driver.find_element_by_xpath("//h3").text)
        driver.find_element_by_link_text("Valimised").click()
        # ERROR: Caught exception [ERROR: Unsupported command [getAllFields |  | ]]
        self.assertEqual("Valimised", driver.find_element_by_xpath("//h2").text)
        driver.find_element_by_xpath("//input[@type='text']").clear()
        driver.find_element_by_xpath("//input[@type='text']").send_keys("riigikogu")
        driver.find_element_by_id("8").click()
        self.assertEqual("#8", driver.find_element_by_xpath("//h3").text)
        driver.find_element_by_link_text("VAATA KANDIDAATE").click()
        bodyText = driver.find_element_by_css_selector("BODY").text
        # ERROR: Caught exception [ERROR: Unsupported command [getAllFields |  | ]]
        self.assertEqual("Kandidaadid", driver.find_element_by_xpath("//h2").text)
        # ERROR: Caught exception [ERROR: Unsupported command [getTable | searchTextResults.1.1 | ]]
        driver.find_element_by_id("9").click()
        # ERROR: Caught exception [ERROR: Unsupported command [getAllFields |  | ]]
        self.assertEqual("#9", driver.find_element_by_xpath("//h3").text)
        driver.find_element_by_link_text(u"E-Hääletamine").click()
        self.assertEqual("Tere tulemast!", driver.find_element_by_xpath("//h3").text)
    
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
