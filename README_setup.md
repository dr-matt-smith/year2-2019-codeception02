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
	
You are now ready to start Unit and Acceptance testing with Codeception

