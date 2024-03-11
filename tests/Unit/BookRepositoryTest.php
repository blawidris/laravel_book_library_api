<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use App\Repositories\BookRepository;
use Tests\TestCase;

class BookRepositoryTest extends TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(BookRepository::class);

        // compare result
        $result = $repository->create($this->payload());
        $this->assertSame($this->payload()['title'], $result['title'], 'Created book does not match');
    }
    public function test_update()
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
    public function test_delete()
    {
        // create a new book
        $repository = $this->app->make(BookRepository::class);
        $result = $repository->create($this->payload());

        // delete result
        $deleted = $repository->delete($result['id']);

        $this->assertTrue($deleted, 'result was not deleted');
    }

    private function payload()
    {
        return [
            'title' => 'Mr/Mrs Smith',
            'author' => 'John',
        ];
    }
}
