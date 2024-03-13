<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Models\Author;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\BookRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book()
    {
        $repository = $this->app->make(BookRepository::class);

        // compare result
        $result = $repository->create($this->payload());
        $this->assertSame($this->payload()['title'], $result['title'], 'Created book does not match');
    }
    public function test_update_book()
    {
        $repository = $this->app->make(BookRepository::class);

        $result = $repository->create($this->payload());

        // update result
        $newPayload = [
            'title' => "Running",
            'author' => 'Rebecca'
        ];

        $updateResult = $repository->update($result['id'], $newPayload);

        $this->assertSame($newPayload['title'], $updateResult['title'], 'Updated book does not match');
    }
    public function test_delete_book()
    {
        // create a new book
        $repository = $this->app->make(BookRepository::class);
        $result = $repository->create($this->payload());

        // delete result
        $deleted = $repository->delete($result['id']);

        $this->assertTrue($deleted, 'result was not deleted');
    }

    public function test_checkout_book()
    {
        $this->factory();

        $book = Book::first();
        $user = User::first();

        // dd($book, $user);

        $repository = $this->app->make(BookRepository::class);
        $result = $repository->checkout($book, $user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, $result->book_id);
        $this->assertEquals($user->id, $result->user_id);
    }

    public function test_checkin_book()
    {
        $this->factory();

        $book = Book::first();
        $user = User::first();

        // checkout book
        $repository = $this->app->make(BookRepository::class);
        $result = $repository->checkout($book, $user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, $result->book_id);
        $this->assertEquals($user->id, $result->user_id);

        // checkin book
        $checkin =(bool) $repository->checkin($book, $user);
        $this->assertTrue($checkin, 'Book Checkin failed ');
    }

    public function test_checkout_a_book_twice(){
        $this->factory();

        $book = Book::first();
        $user = User::first();

        // checkout book
        $repository = $this->app->make(BookRepository::class);
        $result = $repository->checkout($book, $user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, $result->book_id);
        $this->assertEquals($user->id, $result->user_id);

        // checkin book
        $checkin =(bool) $repository->checkin($book, $user);
        $this->assertTrue($checkin, 'Book Checkin failed ');

         // checkout book
         $repository = $this->app->make(BookRepository::class);
         $newCheckout = $repository->checkout($book, $user);
 
         $this->assertCount(2, Reservation::all());
         $this->assertEquals($book->id, $newCheckout->book_id);
         $this->assertEquals($user->id, $newCheckout->user_id);
    }

    public function test_throw_exception_when_checkout_is_not_found()
    {
        $this->expectException(\Exception::class);

        $this->factory();

        $book = Book::first();
        $user = User::first();

        $repository = $this->app->make(BookRepository::class);
        $checkin =(bool) $repository->checkin($book, $user);
        $this->assertNotTrue(!$checkin, 'Book Checkin failed ');
        
    }

    private function payload()
    {
        return [
            'title' => 'Mr/Mrs Smith',
            'author' => 'John',
        ];
    }

    private function factory()
    {
        Book::factory(1)->create();
        User::factory(1)->create();
    }
}
