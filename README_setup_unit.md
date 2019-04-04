## Codeception setup

1. Create new project - skip this step if adding testing to an existing project

1. Create a `composer.json` for the namespace you are using (e.g. `Tudublin` ) - skip this step if adding testing to an existing project

1. Use Composer to add the Codeception library to your project

	```bash
		composer require codeception/codeception
	```
	
1. Run the Codeception **bootstrap**:

	```bash
		vendor/bin/codecept bootstrap
		
		File codeception.yml created       <- global configuration
        > Unit helper has been created in tests/_support/Helper
        > UnitTester actor has been created in tests/_support
        > Actions have been loaded
        tests/unit created                 <- unit tests
        tests/unit.suite.yml written       <- unit tests suite configuration
        > Functional helper has been created in tests/_support/Helper
        > FunctionalTester actor has been created in tests/_support
        > Actions have been loaded
        tests/functional created           <- functional tests
        tests/functional.suite.yml written <- functional tests suite configuration
        > Acceptance helper has been created in tests/_support/Helper
        > AcceptanceTester actor has been created in tests/_support
        > Actions have been loaded
        tests/acceptance created           <- acceptance tests
        tests/acceptance.suite.yml written <- acceptance tests suite configuration
         --- 
        
         Codeception is installed for acceptance, functional, and unit testing 

	```
	
1. 	Unit Testing - naming conventions ...

    - classes should end with `Test`
    
    - methods should begin with `test`
    
	
1. Create a simple Unit test (we'll test 1 + 1 = 2!)

    - generate a new Unit test class to test our Calculator class with `php codecept g:test unit CalculatorTest`:
        
        ```bash
            vendor/bin/codecept g:test unit CalculatorTest
    
            Test was created in /.../tests/unit/CalculatorTest.php    
        ```

    - edit this new testing class `/tests/unit/CalculatorTest.php` to write our simple 1+1=2 method
        
        ```php
          <?php 
          class CalculatorTest extends \Codeception\Test\Unit
          {
              public function testOnePlusOneEqualsTwo()
              {
                  // arrange
                  $expectedResult = 2;
          
                  // act
                  $result = 1 + 1;
          
                  // Assert
                  $this->assertEquals($expectedResult, $result);
              }
          }        
        ```
                
    - run Codeception to see all is working fine:
    
        ```bash
            vendor/bin/codecept run

            Codeception PHP Testing Framework v2.5.5
            Powered by PHPUnit 7.5.8 by Sebastian Bergmann and contributors.
            Running with seed: 

            Acceptance Tests (0) 
            -----------------------------------------------------------------
            -----------------------------------------------------------------
            
            Functional Tests (0) 
            -----------------------------------------------------------------
            -----------------------------------------------------------------
                        
            Unit Tests (1) 
            -----------------------------------------------------------------
             TICK - CalculatorTest: One plus one equals two (0.00s)
            -----------------------------------------------------------------
               
            Time: 107 ms, Memory: 10.00 MB
            OK (1 test, 1 assertion)
        ```
    

 
1. Now we'll create a RED - FAILING - test, to indicate we have code to write to meet requirements:
 
    - add to our testing class `/tests/unit/CalculatorTest.php` a new method, to try to create a object instance - should not be NULL
    
     ```php
        <?php
        use Tudublin\Calculator;
        
        class CalculatorTest extends \Codeception\Test\Unit
        {
            public function testOnePlusOneEqualsTwo()
            {
                // arrange
                $expectedResult = 2;
        
                // act
                $result = 1 + 1;
        
                // Assert
                $this->assertEquals($expectedResult, $result);
            }
        
            public function testCanCreateInstance()
            {
                // arrange
        
                // act
                $calc = new Calculator();
        
                // Assert
                $this->assertNotNull($calc);
            }
        }
     ```     
     
     - the test should fail:
     
        ```bash
            vendor/bin/codecept run

            1) CalculatorTest: Can create instance
             Test  tests/unit/CalculatorTest.php:testCanCreateInstance
                                                    
              [Error] Class 'Calculator' not found  
        ```

1. Now write our Calculator class `/src/Calculator.php`:

    ```php
       <?php
       namespace Tudublin;
       
       
       class Calculator
       {
       
       }
    ```
    
1. Run the test now, and it should be successful:

    ```bash
        vendor/bin/codecept run

        -----------------------------------------------------------------
        Unit Tests (2) 
        TICK - CalculatorTest: One plus one equals two (0.00s)
        TICK - CalculatorTest: Can create instance (0.00s)
        -----------------------------------------------------------------
    ```

1. Now let's add a test for a method `add($n1, $n2)`, add the following method to class `CalculatorTest`:

    ```php
           public function testMethodAddWorks()
           {
               // arrange
               $expectedResult = 2;
               $calc = new Calculator();
       
               // act
               $result = $calc->add(1, 1);
       
               // Assert
               $this->assertEquals($expectedResult, $result);
           }
    ```

    
1. The test should FAIL, since no such method:
    
    ```bash
        [Error] Call to undefined method Tudublin\Calculator::add()  
    ```
    
   
1. Now let's implement this method in our `Calculator` class:

    ```php
       class Calculator
       {
           public function add($n1, $n2)
           {
               return $n1 + $n2;
           }
       }
    ```
    
    - and our new test method should pass:
    
        ```bash
            TICK - CalculatorTest: One plus one equals two (0.00s)
            TICK - CalculatorTest: Can create instance (0.00s)
            TICK - CalculatorTest: Method add works (0.00s)
        ```
        
        
## Data Provider

Let's automate our testing by repeating a testing method with different data.

1. Create a new test class `NewCalculatorTest`

        ```bash
            vendor/bin/codecept g:test unit NewCalculatorTest
    
            Test was created in /.../tests/unit/NewCalculatorTest.php    
        ```
        
1. We now write 2 methods, one is a provider, and one is a test method, taking in parameters from the provider:

    ```php
       <?php
       use Codeception\Test\Unit;
       use Tudublin\Calculator;
       
       class NewCalculatorTest extends Unit
       {
           /**
            * @dataProvider providerAddData
            */
           public function testAddWithProvider($num1, $num2, $expectedResult)
           {
               // arrange
               $calc = new Calculator();
       
               // act
               $result = $calc->add($num1, $num2);
       
               // Assert
               $this->assertEquals($expectedResult, $result);
           }
       
           public function providerAddData()
           {
               return [
                   [1, 1, 2],
                   [2, 2, 4],
                   [5, 2, 7],
               ];
           }
       }
    ```

1. We can now run the unit tests, and we'll see `testAddWithProvider` executed with 3 sets of daeta from our provider:

    ```bash
        TICK - NewCalculatorTest: Add with provider | #0 (0.00s)
        TICK - NewCalculatorTest: Add with provider | #1 (0.00s)
        TICK - NewCalculatorTest: Add with provider | #2 (0.00s)
    ```