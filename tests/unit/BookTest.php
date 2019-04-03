<?php
use Codeception\Test\Unit;
use Tudublin\Book;

class BookTest extends Unit
{
    public function testSetGetAuthor()
    {
        // Arrange
        $author = 'Matt Smith';
        $book = new Book();
        $book->setAuthor($author);
        $expectedResult = 'Matt Smith';

        // Act
        $result = $book->getAuthor();

        // Assert
        $this->assertEquals($expectedResult, $result);
//        $this->assertInternalType('string', $result);
    }

}