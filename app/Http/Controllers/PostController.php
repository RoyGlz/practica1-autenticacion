<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('author', 'category', 'tags')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create([
            'title'        => $request->title,
            'content'      => $request->content,
            'category_id'  => $request->category_id,
            'published_at' => $request->published_at,
        ]);

        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post creado exitosamente');
    }

    public function show(Post $post)
    {
        $post->load('author', 'category', 'tags', 'comments.author');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post actualizado');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post eliminado');
    }
}