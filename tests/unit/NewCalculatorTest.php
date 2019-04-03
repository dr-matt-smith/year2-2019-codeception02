<?php
use Codeception\Test\Unit;
use Tudublin\Calculator;

class NewCalculatorTest extends Unit
{
    public function test_1_CanCreateInstance()
    {
        // Arrange

        // Act
        $calc = new Calculator();

        // Assert
        $this->assertNotNull($calc);
    }

    /**
     * @dataProvider providerAddData
     */
    public function test_2_AddWithProvider($num1, $num2, $expectedResult)
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
            [10, 10, 20]
        ];
    }

    public function test_2_MultiplyWithValidDataTwoAndThreeMakesSix()
    {
        // Arrange
        $num1 = 2;
        $num2 = 3;
        $expectedResult = 6;

        // Act
        $calc = new Calculator();
        $result = $calc->multiply($num1, $num2);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }


    public function testMultiplyWithValidDataFourAndFiveMakesTwenty()
    {
        // Arrange
        $num1 = 4;
        $num2 = 5;
        $expectedResult = 20;

        // Act
        $calc = new Calculator();
        $result = $calc->multiply($num1, $num2);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerForMultiply
     */
    public function testMultiplyWithProvider($num1, $num2, $expectedResult)
    {
        // Arrange

        // Act
        $calc = new Calculator();
        $result = $calc->multiply($num1, $num2);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function providerForMultiply()
    {
        return [
            [2, 2, 4],
            [1, 10, 10],
            [5, 4, 20],
            [0, 5, 0],
            [0, 1, 0],
            [0, 100, 0],
            [0, 0, 0],
        ];
    }

}