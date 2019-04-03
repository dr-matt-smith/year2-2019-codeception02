<?php
use Codeception\Test\Unit;
use Tudublin\Calculator;

class CalculatorTest extends Unit
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
}