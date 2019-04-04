<?php 

class AdminCest
{
    public function canLoginWithValidAdminCredentialsAndSeeAdminHome(AcceptanceTester $I)
    {
        // Arrange / Act
        // goto page
        $I->amOnPage('/index.php?action=login');

        // enter data into fields
        $I->fillField('username', 'admin');
        $I->fillField('password', 'pass');

        // Assert - values in the form fields (before submission)

        // by input ID
        $I->seeInField('#username[value]','admin');
        $I->seeInField('#password[value]','pass');

        // by input name
        $I->seeInField('input[name="username"]','admin');
        $I->seeInField('input[name="password"]','pass');

        // Act - submit form
        $I->click('LOGIN');

        // Assert - should see ADMIN home contents
        $I->see( 'Admin home', 'body h1');

        // do NOT error - since login was successful
        $I->dontSee('error');


    }


    /**
     * test login FAILS with bad data
     */
    public function loginWithInvalidDataGivesErrorMessage(AcceptanceTester $I)
    {
        // Arrange / Act
        $I->amOnPage('/index.php?action=login');

        $I->fillField('username', 'skdjjfhgdsk');
        $I->fillField('password', 'adkjsdfhgkjsfhfgkjsmin');
        $I->click('LOGIN');

        // Assert
        $I->see('error');

        // Assert - should NOT see ADMIN home contents
        $I->dontSee( 'Admin home', 'body h1');

    }

    /**
     * Part E - when not logged in, should not be able to visit admin home page
     */
    public function attemptToVisitAdminHomeWithoutLoginGivesErrorMessage(AcceptanceTester $I)
    {
        // Arrange / Act
        $I->amOnPage('/index.php?action=adminHome');

        // Assert
        $I->see('error');
    }
}
