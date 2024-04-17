<?php

namespace App\Http\Controllers;

use App\Events\NewCommentEvent;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function store(Request $request, Post $post)
    {
       
        $validator = Validator::make($request->all(), [
            'body'=> 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $comment = $post->comments()->create(array_merge($request->all(), ['user_id' => Auth::user()->id]));

        event(new NewCommentEvent($comment));

        return response()->json($comment, 201);
    }

    public function show(Post $post)
    {
        $data = $post->comments()->with('user')->latest()->get();
        return response()->json($data);
    }
}
