<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views if not already viewed in this session
        $viewedKey = 'viewed_post_' . $post->id;
        if (!session()->has($viewedKey)) {
            $post->increment('views_count');
            
            PostView::create([
                'post_id' => $post->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'user_id' => auth()->id(),
            ]);
            
            session()->put($viewedKey, true);
        }
            
        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'recentPosts'));
    }
}
