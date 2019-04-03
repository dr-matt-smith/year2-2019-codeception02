<?php 
use Codeception\Example;

class IndexPageCest
{
    public function homePageHasTextInLevelOneHeading(AcceptanceTester $I)
    {
        // Act
        $I->amOnPage('/');

        // Assert - what should be true
        $I->see('home page');

        // use CSS selector to specify that it is in an <h1> that we expected to see this text
        $I->see('home page', 'body h1');
        $I->see('home page', ['css' => 'body h1']);
    }


    /**
     * Acceptance test - example of data provider - Doctrine style
     *
     * @example(linkText="home")
     * @example(linkText="login")
     * @example(linkText="Admin home")
     */
    public function testLinksOnHomePageWithDataProvider(AcceptanceTester $I, Example $example)
    {
        // Act
        $I->amOnPage('/');

        // Assert
        $I->seeLink($example['linkText']);
    }

    /**
     * Acceptance test - example of data provider - Unit test style
     *
     * @dataProvider _providerLinkTexts
     */
    public function testLinksOnHomePageWithDataProvider2(AcceptanceTester $I, Example $example)
    {
        // Act
        $I->amOnPage('/');

        // Assert
        $I->seeLink($example['linkText']);
    }

    public function _providerLinkTexts()
    {
        return [
                [ 'linkText' => "home" ],
                [ 'linkText' => "login" ],
                [ 'linkText' => "Admin home" ],
        ];
    }
}
