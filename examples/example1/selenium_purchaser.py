from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time
import sys

def main():
    # Setup WebDriver
    driver = webdriver.Chrome()  # Update as per your driver

    try:
        # Navigate to the initial website
        driver.get("https://www.freshbrothers.com/locations/")

        # Find and click the <a> tag with class 'primary-bttn'
        primary_button = driver.find_element(By.CLASS_NAME, "primary-bttn")
        primary_button.click()

        # WebDriverWait could be used here for better synchronization (not shown for simplicity)
        time.sleep(2)  # Simple sleep, waiting for page load/operations

        # Find and click the button inside a div with class 'submit-info-block'
        submit_info_btn = driver.find_element(By.CSS_SELECTOR, '.submit-info-block button')
        submit_info_btn.click()

        # Find and click the button inside the div with data-m3id
        specific_div_button = driver.find_element(By.CSS_SELECTOR, 'div[data-m3id="65ssj0q23n85d03gn6qmtb"] button')
        specific_div_button.click()

        time.sleep(2)  # Simple sleep, waiting for operations

        # Click on the first occurrence of a label with class 'custom-control-label'
        custom_control_label = driver.find_element(By.CLASS_NAME, "custom-control-label")
        custom,control_label.click()

        time.sleep(1)  # Simple sleep

        # Print inner HTML of all tags with a class 'order-info-cart-button'
        cart_buttons = driver.find_elements(By.CLASS_NAME, "order-info-cart-button")
        for button in cart_buttons:
            print(button.get_attribute('innerHTML'))

    finally:
        # Quit the driver
        driver.quit()

if __name__ == "__main__":
    main()
