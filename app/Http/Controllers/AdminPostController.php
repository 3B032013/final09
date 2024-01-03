<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at','DESC')->get();
        $data = ['posts' => $posts];
        return view('admins.posts.index',$data);
    }

    public function create()
    {
        return view('admins.posts.create');
    }

    public function store(Request $request)
    {
        $admin = Auth::user()->admin;

        $this->validate($request, [
            'title' => 'required|max:50',
            'content' => 'required',
        ]);

        // Create a new post instance
        $post = new Post($request->all());

        // Associate the admin with the post
        $post->admin()->associate($admin);

        // Save the post to the database
        $post->save();

        return redirect()->route('admins.posts.index');
    }

    public function edit(Post $post)
    {
        $data = [
            'post'=> $post,
        ];
        return view('admins.posts.edit',$data);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title' => 'required|max:50',
            'content' => 'required',
        ]);

        $post->update($request->all());
        return redirect()->route('admins.posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admins.posts.index');
    }
}
