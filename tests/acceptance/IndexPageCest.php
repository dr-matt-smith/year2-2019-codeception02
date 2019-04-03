<?php 

class IndexPageCest
{

    public function loginLinkOnHomePage(AcceptanceTester $I)
    {
        // arrange / act
        $I->amOnPage('/');

        // assert
        $I->seeLink('login');
    }

    public function homepageWorking(AcceptanceTester $I)
    {
        // Act
        $I->amOnPage('/');

        // Assert - what should be true
        $I->see('home page');

        // use CSS selector to specify that it is in an <h1> that we expected to see this text
        $I->see('home page', 'body h1');
        $I->see('home page', ['css' => 'body h1']);
    }

}
