<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_checked_out_by_signed_in_user(): void
    {

        $book = Book::factory()->create();

        $this->actingAs($user = User::factory()->create())->post('/checkout/' . $book['id']);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book['id'], Reservation::first()->book_id);
        $this->assertEquals($user['id'], Reservation::first()->user_id);
        // $this->assertEquals(now(), Reservation::first()['checkout_at']);
    }

    public function test_only_signed_in_users_can_checkout_a_book()
    {
        // $this->withoutExceptionHandling();

        $book = Book::factory()->create();
        $this->post('/checkout/' . $book['id'])
            ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    public function test_only_existing_book_can_be_booked()
    {
        $this->actingAs($user = User::factory()->create())
            ->post('/checkout/12')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
