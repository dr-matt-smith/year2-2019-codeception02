<?php
use Codeception\Test\Unit;
use Tudublin\Book;

class Book2Test extends Unit
{
    public function testCanCreateBookObject()
    {
        // Arrange

        // Act
        $book = new Book();

        // Assert
        $this->assertNotNull($book);
    }

    public function testGetAuthorSameAsSetAuthor()
    {
        // Arrange
        $author = 'Matt Smith';
        $book = new Book();

        // Act
        $book->setAuthor($author);
        $result = $book->getAuthor();

        // Assert
        $this->assertEquals('Matt Smith', $result);
    }

}