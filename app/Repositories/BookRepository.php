<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Book;

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
}
