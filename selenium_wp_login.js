/** // Wordpress automated login // **/

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
    .setChromeOptions(new chrome.Options().windowSize(desktop)) //set specific screen size for responsive testing
    .setChromeOptions(new chrome.Options().addArguments('--headless')) //set to headless to keep the UI from opening on local, disable if you want to see it
    .build();

//firefox drivers
let driver_firefox = new webdriver.Builder()
    .forBrowser('firefox')
    .setFirefoxOptions(new firefox.Options().windowSize(desktop))
    //.setFirefoxOptions(new firefox.Options().addArguments('--headless'))
    .build()

const testURL = 'https://vectordefector.com/wp-admin/';

async function initSeleniumTest(driver){

    const actions = driver.actions({async: true});

    await driver.get(testURL).then(async function(){    

        await driver.getTitle().then(async function(title){            
                
            if(title.indexOf('Log In') > -1 && title.indexOf('WordPress') > -1){

                console.log('Goto "'+title+'" Page');

                //fill form elements                  
                driver.findElement(By.name('log')).sendKeys('[myrealusername]');
                driver.findElement(By.name('pwd')).sendKeys('[myrealpassword]'); // change values to test validation!!

                await driver.sleep(1000); //pause to make sure it fills the fields

                //submit & check results
                await driver.findElement(By.name("wp-submit")).click().then(async function(){

                    await driver.getTitle().then(async function(title){     

                        if(title.indexOf('Dashboard') > -1 && title.indexOf('WordPress') > -1){
                            //success
                            console.log('Success: Logged In');
                            driver.quit();
                        } else {
                            //error
                            console.log('Error: Username/Pass');
                            getScreenShot(driver,'login_fail_');
                            driver.quit();
                        }
                    });

                });

            } else {                       
                console.log('Failed: Wrong URL');
                getScreenShot(driver,'URL_fail_'); //takes screenshot on fail
                driver.quit(); //quit terminates the test
                //driver.close(); //closes tab, use close if more iterations
            }          
            
        })

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