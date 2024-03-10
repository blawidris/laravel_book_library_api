<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_author_can_be_created(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/author', [
            'name' => 'Robert K',
            'dob' => '2000/11/25'
        ]);

        $response->assertStatus(201);


        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2000/11/25', $author->first()->dob->format('Y/m/d'));
    }
}
