/** // VectorDefector Contact Form automation testing // **/

//set includes
const webdriver = require('selenium-webdriver'),
    By = webdriver.By,
    Key = webdriver.Key,
    until = webdriver.until;
const test = require('selenium-webdriver/testing');
const chrome = require('selenium-webdriver/chrome');
const firefox = require('selenium-webdriver/firefox');

//define default screen size
const desktop = {
    width: 1920,
    height: 1080    
  };

const tablet = {
    width: 768,
    height: 1024
  };

const android = {
    width: 411,
    height: 731
};

const iphone = {
    width: 375,
    height: 812
};

//chrome drivers
let driver_chrome = new webdriver.Builder()
    .forBrowser('chrome')
    //.setChromeOptions(new chrome.Options().excludeSwitches('enable-logging')) //disable logging to skip other site output
    .setChromeOptions(new chrome.Options().windowSize(desktop)) //set specific screen size for responsive testing
    .setChromeOptions(new chrome.Options().addArguments('--headless')) //set to headless to keep the UI from opening on local, disable if you want to see it
    .build();

//firefox drivers
let driver_firefox = new webdriver.Builder()
    .forBrowser('firefox')
    .setFirefoxOptions(new firefox.Options().windowSize(desktop))
    //.setFirefoxOptions(new firefox.Options().addArguments('--headless'))
    .build()

const testURL = 'https://vectordefector.com/';

async function initSeleniumTest(driver){

    const actions = driver.actions({async: true});

    await driver.manage().window().maximize(); //maximize window within set size range
    //await driver.manage().window().fullscreen(); //reset window to fullscreen like F11

    await driver.get(testURL).then(async function(){    

        let navBtn = driver.findElement(By.css("#menu-item-1938 a"));

        await driver.sleep(3000); //pause to make sure page is loaded

        //click the "Connect" contact page nav element        
        await navBtn.click().then(async function(){

            await driver.getTitle().then(async function(title){            
                    
                if(title === 'Connect - VectorDefector'){

                    console.log('Goto "'+title+'" Page');

                    //fill form elements                  
                    driver.findElement(By.name('your-name')).sendKeys('Tom Tester');
                    //driver.findElement(webdriver.By.name('your-phone')).sendKeys('Tom Tester'); // change values to something wrong to test validation!!
                    driver.findElement(By.name('your-phone')).sendKeys('303-555-5555');
                    //driver.findElement(webdriver.By.name('your-email')).sendKeys('notanemail@stuff'); // change values to something wrong to test validation!!
                    driver.findElement(By.name('your-email')).sendKeys('tom@mailinator.com');                     
                    driver.findElement(By.name('your-location')).sendKeys('Denver'); 
                    driver.findElement(By.name('your-message')).sendKeys('Tom Test TEst'); 

                    //submit & check results
                    await driver.findElement(By.css(".wpcf7-submit")).click().then(async function(){

                        await driver.sleep(3000); //pause to make sure form fully returns

                        let element = driver.findElement(By.css(".wpcf7-response-output"));
                        let outputText = element.getText().toString();

                         await driver.executeScript("arguments[0].scrollIntoView();", element).then(async function() {
                            
                            await driver.sleep(1000); //pause to let it scroll

                            if(outputText.indexOf('success') !== -1){
                                console.log('Success: Submit form');
                                getScreenShot(driver,'form_sucess_')
                                driver.quit();
                            } else {
                                console.log('Failed: Submit form');                                
                                getScreenShot(driver,'form_fail_');
                                driver.quit();
                            } 

                        });

                    });

                } else {                       
                    console.log('Failed: Contact URL');
                    getScreenShot(driver,'URL_fail_'); //takes screenshot on fail
                    driver.quit(); //quit terminates the test
                    //driver.close(); //closes tab, use close if more iterations
                }          
                
            })

         });
    });
}

function getScreenShot(driver,name) {

    const timeStamp = Date.now().toString();

    const FS = require('fs');

    if(!name) {
        let name = 'screenshot_'; 
    }   

    driver.takeScreenshot().then(function(image) {
        FS.writeFileSync(name+timeStamp+'.jpg', image, 'base64'); //writes a jpg from raw screenshot data
    });
}

initSeleniumTest(driver_chrome);

//initSeleniumTest(driver_chrome).then(console.log); // fire log messages after function if disabling console output