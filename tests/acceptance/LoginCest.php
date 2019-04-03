<?php 

class LoginCest
{
    public function homePageHasLoginLink(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/');

        // assert
        $I->seeLink('login');
    }

    public function homePageLoginLinkLeadsToLoginPage(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/');
        $I->click('login');

        // assert
        $I->seeInCurrentUrl('action=login');
        $I->seeElement('input[name=username]');
    }


    public function homePageLoginLinkHasCorrectActionInUrl(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/');
        $I->click('login');

        // assert
        $I->seeInCurrentUrl('index.php?action=login');
    }

    public function loginFormHasUserNameAndPasswordInputs(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/index.php?action=login');

        // see text in HTML body
        $I->see('username','body');
        $I->see('password','body');

        // see Form inputs
        $I->seeElement('input', ['name' => 'username']);
        $I->seeElement('input', ['name' => 'password']);

    }

    public function loginFormHasLOGINSubmitButton(AcceptanceTester $I)
    {
        // Arrange / Act
        $I->amOnPage('/index.php?action=login');

        // Assert

        // submit button has value 'LOGIN'
        $I->seeInField('input[type="submit"]','LOGIN');

        // submit button has name 'login_name'
        $I->seeInField('input[name="login_name"]','LOGIN');

        // an element with ID = 'login_id'
        $I->seeElement('#login_id');
    }

    /**
     * test login FAILS with bad data
     */
    public function loginWithBadCredentialsLeadsToErrorMessage(AcceptanceTester $I)
    {
        // Arrange / Act
        $I->amOnPage('/index.php?action=login');

        $I->fillField('username', 'skdjjfhgdsk');
        $I->fillField('password', 'adkjsdfhgkjsfhfgkjsmin');
        $I->click('LOGIN');

        // Assert
        $I->see('error');
    }
}
