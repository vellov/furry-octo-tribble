# -*- coding: utf-8 -*-
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import Select
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import NoAlertPresentException
import unittest, time, re
from ConfigParser import SafeConfigParser

class ElectionTest(unittest.TestCase):
    def setUp(self):
        self.driver = webdriver.Firefox()
        self.driver.implicitly_wait(30)
        self.base_url = "https://pacific-sea-1219.herokuapp.com/"
        self.verificationErrors = []
        self.accept_next_alert = True
    
    def test_election(self):
        #conf
        parser = SafeConfigParser()
        parser.read('testConfig.ini')
        lastElectionID = str(parser.get('test_id', 'lastElectionID'))
        parser.set('test_id', 'lastElectionID', str(int(lastElectionID)+1))
        
        driver = self.driver
        driver.get(self.base_url + "#/")
        window_before = driver.window_handles[0]
        driver.find_element_by_css_selector("button.btn.btn-primary").click()
        print window_before
        window_after = driver.window_handles[1]
        driver.switch_to_window(window_after)
        print window_after
        # ERROR: Caught exception [ERROR: Unsupported command [waitForPopUp |  | 30000]]
        # ERROR: Caught exception [ERROR: Unsupported command [selectPopUp |  | ]]
        driver.find_element_by_id("email").clear()
        driver.find_element_by_id("email").send_keys("webapp.testuser2@gmail.com")
        driver.find_element_by_id("pass").clear()
        driver.find_element_by_id("pass").send_keys("veebirakendus")
        driver.find_element_by_name("login").click()
        driver.switch_to_window(window_before)
        # ERROR: Caught exception [ERROR: Unsupported command [selectWindow | null | ]]
        driver.find_element_by_link_text("Uus valimine").click()
        driver.find_element_by_name("nimetus").clear()
        driver.find_element_by_name("nimetus").send_keys("Uus testvalimine")
        driver.find_element_by_name("kirjeldus").clear()
        driver.find_element_by_name("kirjeldus").send_keys("Testvalimise kirjeldus.")
        driver.find_element_by_css_selector("button.btn.btn-success").click()
        time.sleep(1)
        with open('testConfig.ini', 'w') as configfile:    # save
            parser.write(configfile)
        driver.find_element_by_id(lastElectionID).click()
        self.assertEqual("#"+lastElectionID, driver.find_element_by_xpath("//h3").text)
        driver.find_element_by_link_text("KUSTUTA VALIMINE").click()
        driver.find_element_by_css_selector("#deleteElectionModal > div.modal-dialog > div.modal-footer > button.btn.btn-danger").click()
        self.assertNotEqual("id="+lastElectionID, driver.current_url)
        driver.find_element_by_link_text("Avaleht").click()
        
    
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
