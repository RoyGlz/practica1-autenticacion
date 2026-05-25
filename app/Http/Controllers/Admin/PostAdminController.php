<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Audit;
use App\Http\Requests\StorePostWithAttachmentsRequest;
use App\Services\FileService;

class PostAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,editor');
    }

    public function index()
    {
        $posts = Post::with('author', 'category')->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
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

        return redirect()->route('admin.posts.show', $post)
            ->with('success', 'Post creado exitosamente');
    }

    public function show(Post $post)
    {
        $audits = Audit::where('model_type', 'Post')
            ->where('model_id', $post->id)
            ->latest()
            ->get();

        return view('admin.posts.show', compact('post', 'audits'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(StorePostWithAttachmentsRequest $request, Post $post)
    {
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

        return redirect()->route('admin.posts.show', $post)
            ->with('success', 'Post actualizado');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post eliminado');
    }
}