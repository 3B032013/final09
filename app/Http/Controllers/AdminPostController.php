<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $posts = Post::orderBy('created_at','DESC')->paginate($perPage);
        $data = ['posts' => $posts];
        return view('admins.posts.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);
        $posts = Post::where('title', 'like', "%$query%")
            ->paginate($perPage);

        // 返回結果
        return view('admins.posts.index', [
            'posts' => $posts,
            'query' => $query,
        ]);
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

    public function statusOn(Request $request, Post $post)
    {
        $post->update(['status' => 1]);
        return redirect()->route('admins.posts.index');
    }

    public function statusOff(Request $request, Post $post)
    {
        $post->update(['status' => 0]);
        return redirect()->route('admins.posts.index');
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
