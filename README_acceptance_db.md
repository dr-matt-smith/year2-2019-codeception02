# Acceptance testing with Databases

## Configuring for _your_ database
    
1. Database credentials 

    - edit the credentials in file `codeception.yml` to match your database name / user / password
    
        ```yaml
           dsn: 'mysql:host=localhost;dbname=evote'
           user: 'root'
           password: 'passpass'
           dump: 'tests/_data/dump.sql'
        ```
    
1. SQL dump:

    - create / copy the SQL to create your database tables, and insert initial fixtures test data as file to match the `dump` configuration location
    
    - i.e. `tests/_data/dump.sql` 
    
    - in most cases this will be the same as the contents of your `/db` folder, if you have been following Matt's examples. Here is a typical SQL dump used for resetting the Database stucture and contents **before** each test in run (to keep tests independent of each other):>
    
        ```sql
            -- create the table
            create table if not exists movie (
                id integer primary key AUTO_INCREMENT,
                title text,
                price float
            );
            
            -- insert some data
            insert into movie values (1, 'Jaws',9.99);
            insert into movie values (2, 'Jaws2',4);
            insert into movie values (3, 'Mama Mia',9.99);
            insert into movie values (4, 'Forget Paris',8);
        ```
    
    
That's it - you should now have a Codeception configuration that will reset the database to match your `dump` SQL contents before each test is ruin


NOTE: Since testing involves resetting the database each time, it is common practice to use a DIFFERENT database schema for your testing, than your **live** website database. You can do this easily, just change the name of the database in the `dsn` configuration, e.g. add the suffix `test`:

```yaml
   dsn: 'mysql:host=localhost;dbname=evotetest'
```

## Writing DB acceptance tests - counting records

If we were testing using the above SQL dump, we know there should be 4 records in table `movie` when each test begins. 

Just by **counting** the number of records in a table, we can write tests that change the database such as the following:

    - test to create new record in DB - number of records should be 5 after actions
    
    - test to DELETE a record - number of records should be 3 after actions
    
    - test to DELETE all records - number of records should be 0 after actions
    

1. We use `g:cest` to generate an acceptance test:

	```bash
		vendor/bin/codecept g:cest acceptance CreateRecordsCest
	```
	
	- Acceptance test class `tests/acceptance/CreateRecordsCest.php` should have been created
	
1. Edit the class to test that the text `home page` can be found when we visit `/` in our web browser:

    ```php
       <?php 
       
       class HomePageCest
       {
            public function testInitialRecordsInDatabaseAsExpected(AcceptanceTester $I)
            {
                $I->seeNumRecords(4, 'dvds');  //executed on db_books database
        
            }
        
            public function indexCreateOneRecord(AcceptanceTester $I)
            {
                $I->amOnPage('/');
                $I->seeNumRecords(5, 'dvds');  //executed on db_books database
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
        


## The PPPBrowser class

All the methods that `$I` can perform are defined in PhpBrowser module of Cdeoception. Learn more at the Codeception documentation pages:

- https://codeception.com/docs/modules/PhpBrowser

Some of the most common methods we use in Acceptance Testing are illustraterd below.

### Actions (go to page / click link / fill in form field)

- make browser request a specific URL:
    
    ```php
        $I->amOnPage('<url>');
        e.g.
        $I->amOnPage('/index.php?action=login');
    ```


- fill in a form field with a value:

    ```php
        $I->fillField(<fieldName>, <value>);
        e.g.
        $I->fillField('username', 'admin');
    ```

- click a link or submit button:
        
    ```php
        $I->click(<linkText-or-submit-button-text>);
        e.g.
        $I->click('LOGIN');
    ```

### Assertions (testing what should be true)

- see some specific content in the current URL:

    ```php
        $I->seeInCurrentUrl(<part-of-url>);
        e.g.
        $I->seeInCurrentUrl('action=about');
    ```

- see text in the HTML Response returned to the browser (could be in HTML title and not seen by user):
    
    ```php
        $I->see(<text>);
        e.g.
        $I->see('home page');
    ```

- see text in a specific element (using CSS selectors):
    
    ```php
        $I->see(<css selector>, <text>);
        e.g.
         $I->see('home page', 'body h1');
    ```

- see text that is a link, or a submit button with a value:

    ```php
        $I->seeLink(<linkText>);
        e.g.
        $I->seeLink('back to home');
    ```
    
- see a specific element, with ID or Class selector:

    ```php
        $I->seeElement(<elementSelector>);
        e.g.
        $I->seeElement('#login_id');
    ```

    
### Negative assertions (stating something should NOT be true)

- do NOT see some text

    ```php
        $I->dontSee(textNotExpectToSee);

        e.g. after what should be a successful action
        $I->dontSee('error');
    ```



