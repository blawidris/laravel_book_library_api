<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryBook;
use App\Http\Requests\StoreLibraryBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Book::all();
    }

    public function store(StoreLibraryBookRequest $request)
    {

        $storedBook = DB::transaction(function () use ($request) {
            // check if author exists already or create a new one
            $author = Author::firstOrCreate(['name' => $request->author]);

            // store new book if author is found or created
            return Book::create([
                'title' => $request->title,
                'author_id' => $author->id
            ]);
        });

        // $storedBook = Book::create([
        //     'title' => $request->title,
        //     'author' => $request->author
        // ]);


        return $storedBook->load('author');


        // return redirect("/books/{$storedBook->id}", 201);
    }

    public function show(Book $book)
    {
        return $book;
    }

    public function update(Book $book, StoreLibraryBookRequest $request)
    {

        // update book author information if exists or create a new one
        $author = $book->author()->updateOrCreate([
            'name' => $request->author
        ]);

        // update book
        $updateBook = $book->update([
            'title' => $request->title,
            'author_id' => $author->id
        ]);

        return $book->load('author');
    }

    public function destroy(Book $book)
    {
        return $book->delete() ? redirect('/books') : "Book is not deleted";
    }
}
