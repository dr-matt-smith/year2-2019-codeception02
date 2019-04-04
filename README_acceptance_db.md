# Acceptance testing with Databases

## Configuring for _your_ database
    
1. Database credentials 

    - edit the credentials in file `codeception.yml` to match your database name / user / password
    
        ```yaml
            - Db:
                  dsn: 'mysql:host=localhost;dbname=evote'
                  user: 'root'
                  password: 'passpass'
                  dump: 'tests/_data/dump.sql'
                  populate: true
                  cleanup: true
                  reconnect: true
                  waitlock: 10
        ```
        
    - so your full should look something like this:
    
        ```yaml
              paths:
                  tests: tests
                  output: tests/_output
                  data: tests/_data
                  support: tests/_support
                  envs: tests/_envs
              actor_suffix: Tester
              extensions:
                  enabled:
                      - Codeception\Extension\RunFailed
              modules:
                  enabled:
                      - Db:
                            dsn: 'mysql:host=localhost;dbname=evote'
                            user: 'root'
                            password: 'passpass'
                            dump: 'tests/_data/dump.sql'
                            populate: true
                            cleanup: true
                            reconnect: true
                            waitlock: 10
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
	
1. Edit the class to test that there are 4 records in the database initially:

    ```php
       <?php 
       
       class CreateRecordsCest
       {
            public function testInitialRecordsInDatabaseAsExpected(AcceptanceTester $I)
            {
                $I->seeNumRecords(4, 'movie');  //executed on db_books database
        
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
    
    - it should all work fine:
    
        ```bash
        Acceptance Tests (2) 
        
        ----------------------------------------
        TICK CreateRecordsCest: Test initial records in database as expected (0.00s)

        ```
  


