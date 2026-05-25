<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attachment;
use App\Http\Requests\StorePostWithAttachmentsRequest;
use App\Services\FileService;

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

    public function store(StorePostWithAttachmentsRequest $request)
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

        if ($request->hasFile('attachments')) {
            $fileService = new FileService();
            foreach ($request->file('attachments') as $file) {
                $fileService->storeAttachment($file, $post->id);
            }
        }

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post creado exitosamente');
    }

    public function show(Post $post)
    {
        $post->load('author', 'category', 'tags', 'comments.author', 'attachments');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(StorePostWithAttachmentsRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'category_id'  => $request->category_id,
            'published_at' => $request->published_at,
        ]);

        $post->tags()->sync($request->tags ?? []);

        if ($request->hasFile('attachments')) {
            $fileService = new FileService();
            foreach ($request->file('attachments') as $file) {
                $fileService->storeAttachment($file, $post->id);
            }
        }

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

    public function destroyAttachment(Attachment $attachment)
    {
        $this->authorize('delete', $attachment->post);

        $fileService = new FileService();
        $fileService->deleteAttachment($attachment);

        return redirect()->back()->with('success', 'Archivo eliminado');
    }
}