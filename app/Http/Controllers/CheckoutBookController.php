<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book, BookRepository $repository)
    {
        $checkout = $repository->checkout($book, Auth::user());

        return $checkout;
    }

    public function update($book, BookRepository $repository){
        $book = $repository->show($book);

        $checkInBook = $repository->checkin($book, Auth::user());

        return $checkInBook;
    }
}
