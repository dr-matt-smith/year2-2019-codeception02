<?php 

class LoginCest
{
    public function loginLinkLeadsToLoginForm(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/');
        $I->click('login');

        // assert
        $I->seeInCurrentUrl('index.php?action=login');

        // see text in HTML body
        $I->see('username','body');
        $I->see('password','body');

        // see Form inputs
        $I->seeElement('input', ['name' => 'username']);
        $I->seeElement('input', ['name' => 'password']);

        // arrange / act

    }

    public function successfulAdminLogin(AcceptanceTester $I)
    {
        // GOTO page
        $I->amOnPage('/index.php?action=login');

        // enter data into fields
        $I->fillField('username', 'admin');
        $I->fillField('password', 'pass');

        // by input ID
        $I->seeInField('#username[value]','admin');
        $I->seeInField('#password[value]','pass');

//         by input name
        $I->seeInField('input[name="username"]','admin');
        $I->seeInField('input[name="password"]','pass');

        // submit form
        $I->click('LOGIN');

        // ADMIN home
        $I->see('admin home page');

    //    $I->seeInCurrentUrl('/index.php?action=adminHome');

    }


    public function failedAdminLogin(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/index.php?action=login');

        $I->fillField('username', 'skdjjfhgdsk');
        $I->fillField('password', 'adkjsdfhgkjsfhfgkjsmin');
        $I->click('LOGIN');
        $I->see('error');

    }



}
