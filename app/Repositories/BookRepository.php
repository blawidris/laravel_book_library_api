<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Exception;

class BookRepository
{

    function create(array $attribute)
    {

        $author = Author::firstOrCreate(['name' => $attribute['author']]);

        $book = Book::create([
            'title' => $attribute['title'],
            'author_id' => $author->id
        ]);
        return $book;
    }

    public function show($book)
    {
        return Book::findOrFail($book);
    }

    public function update($book, array $attribute)
    {
        $book = $this->show($book);

        $author = $book->author()->updateOrCreate([
            'name' => $attribute['author']
        ]);

        $book->fill($attribute)->save();

        return $book;
    }

    public function delete($book)
    {
        $book = $this->show($book);

        return $book->delete() ? true : false;
    }

    public function checkout(Book $book, User $user)
    {
        return $book->reservations()->create([
            'user_id' => $user->id,
            'checkout_at' => now()
        ]);
    }

    public function checkin(Book $book, User $user)
    {
        $reservation =  $book->reservations()
            ->where('user_id', $user->id)
            ->whereNotNull('checkout_at')
            ->whereNull('checkin_at')
            ->first();

        if (is_null($reservation)) {
            throw new Exception('Reservation not found');
        }

        return $reservation->update([
            'checkin_at' => now()
        ]);

        // return $reservation;
    }
}
