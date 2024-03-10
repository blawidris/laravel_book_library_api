<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_add_book_to_the_library_collection(): void
    {
        $response = $this->post('/books', [
            'title' => 'Atomic Habit',
            'author' => 'Kendrick Arnold'
        ]);

        $response->assertStatus(201);

        $this->assertCount(1, Book::all());

        // $response->assertRedirect('/books/'. $response['id']);
    }

    public function test_is_title_required()
    {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Kendrick Arnold'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_is_author_required()
    {

        $response = $this->post('/books', [
            'title' => 'Rich Dad Poor Dad',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_update_book_in_library_collection()
    {
        // $this->withoutExceptionHandling();

        $storeNewBook = $this->post('/books', [
            'title' => 'New Book',
            'author' => 'New Book author'
        ]);



        $response = $this->patch("/books/{$storeNewBook['id']}", [
            'title' => 'Rich Dad Poor Dad',
            'author' => 'Robert K'
        ]);

        $this->assertEquals('Rich Dad Poor Dad', $response['title']);
        $this->assertEquals('Robert K', $response['author']);

        // $response->assertRedirect('/books/'.$response['id']);
    }

    public function test_book_can_be_deleted()
    {

        $storeNewBook = $this->post('/books', [
            'title' => 'Lemanord',
            'author' => 'Kendrick Arnold'
        ]);

        $response = $this->delete("/books/{$storeNewBook['id']}");

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
