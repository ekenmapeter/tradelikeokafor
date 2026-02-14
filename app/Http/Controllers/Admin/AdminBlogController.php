<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'short_description', 'content']);
        $data['is_published'] = $request->has('is_published');
        
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        Post::create($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'short_description', 'content']);
        $wasPublished = $post->is_published;
        $data['is_published'] = $request->has('is_published');

        if ($data['is_published'] && !$wasPublished) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function views(Post $post)
    {
        $views = $post->views()->with('user')->latest()->paginate(50);
        return view('admin.blog.views', compact('post', 'views'));
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
        
            $request->file('upload')->move(public_path('media'), $fileName);
        
            $url = asset('media/' . $fileName);
            return response()->json(['url' => $url]);
        }
    }
}
