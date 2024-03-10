<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
    }

    public function store(StoreNewAuthorRequest $request)
    {
        return Author::create($request->all());
    }
}
