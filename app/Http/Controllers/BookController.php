<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryBook;
use App\Http\Requests\StoreLibraryBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(StoreLibraryBookRequest $request)
    {

        $storedBook = Book::create([
            'title' => $request->title,
            'author' => $request->author
        ]);


        return $storedBook;
    }

    public function update(Book $book, StoreLibraryBookRequest $request)
    {

        $book->fill($request->all())->save();

        return $book;
    }
}
