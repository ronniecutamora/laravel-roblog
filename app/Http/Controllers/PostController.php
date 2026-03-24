<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create($request->validated());

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        $post->load('user');

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'canEdit' => auth()->check() && auth()->id() === $post->user_id,
        ]);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($request->validated());

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
