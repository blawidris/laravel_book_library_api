<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryBook;
use App\Http\Requests\StoreLibraryBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return Book::all();
    }

    public function store(StoreLibraryBookRequest $request)
    {

        $storedBook = Book::create([
            'title' => $request->title,
            'author' => $request->author
        ]);

        return $storedBook;


        // return redirect("/books/{$storedBook->id}", 201);
    }

    public function show(Book $book){
        return $book;
    }

    public function update(Book $book, StoreLibraryBookRequest $request)
    {

       $book->fill($request->all())->save();

        return $book;
    }

    public function destroy(Book $book)
    {
        return $book->delete() ? redirect('/books') : "Book is not deleted";
    }
}
