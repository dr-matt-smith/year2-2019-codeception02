## Acceptance testing

1. We use `g:cest` to generate an acceptance test:

	```bash
		vendor/bin/codecept g:cest acceptance HomePage
	```
	
	- Acceptance test class `tests/acceptance/HomePageCest.php` should have been created
	
1. Edit the class to test that the text `home page` can be found when we visit `/` in our web browser:

    ```php
       <?php 
       
       class HomePageCest
       {
           public function homepageWorking(AcceptanceTester $I)
           {
               // Act - request URL '/'
               $I->amOnPage('/');
            
               // Assert
       
               // you may need to change text/case - to match text appearing on _your_ home page :-)
               // we should see this text somewhere in the contents of the Request
               $I->see('home page');
            
               // use CSS selector to specify that it is in an <h1> that we expected to see this text
               $I->seeInField('body h1', 'home page');
           }
       }
    ```
	
1. In one terminal window, run your web server

1. In a second terminal window, run your acceptance tests (by adding `acceptance` after `run` we are saying we **only** want to run acceptance tests, and ignore any unit or functional tests):

    ```bash
        vendor/bin/codecept run acceptance
    ```
    
    - unless you are using a web server like Apache then it will probably fail, due to Codeception's default web server port guess of 80, rather than our usual 8000:
    
        ```bash
              [GuzzleHttp\Exception\ConnectException] cURL error 7: Failed to connect to localhost port 80: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)  
        ```
        
1. Fix the problem by setting the `url` configuration in `/tests/acceptance.suite.yml` to `http://localhost:800`:

    ```yaml
     actor: AcceptanceTester
     modules:
         enabled:
             - PhpBrowser:
                 url: http://localhost:8000
             - \Helper\Acceptance
    ```
    
    - run the acceptance test again
    
        ```bash
            vendor/bin/codecept run acceptance
        ```
        
    - now it should (hopefully!) pass:
    
        ```bash
            Codeception PHP Testing Framework v2.5.5
            Powered by PHPUnit 7.5.8 by Sebastian Bergmann and contributors.
            Running with seed: 
            
            Acceptance Tests (1) 
            -----------------------------------------------------------------------
            
             TICK - HomePageCest: Homepage working (0.02s)
            
            -----------------------------------------------------------------------
             
            Time: 108 ms, Memory: 12.00 MB
            
            OK (1 test, 1 assertion)

        ```
        
    - if the test still fails, then it means you don't have a level 1 heading containing `home page` on your home page
    
        - either fix the test (to test for some text you want on the home page)
        
        - or fix the contents of the template outputting the home page, to also output `<h1>home page</h1>`
        


## The PhPBrowser class

All the methods that `$I` can perform are defined in PhpBrowser module of Cdeoception. Learn more at the Codeception documentation pages:

- https://codeception.com/docs/modules/PhpBrowser


