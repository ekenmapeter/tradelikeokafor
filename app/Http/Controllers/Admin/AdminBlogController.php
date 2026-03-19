<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.blog.index', compact('posts'));
    }

    public function analytics(Request $request)
    {
        $period = $request->get('period', '30days');
        
        // Determine date range based on period
        switch ($period) {
            case '7days':
                $startDate = Carbon::now()->subDays(7);
                $dateFormat = '%Y-%m-%d';
                $labelFormat = 'M d';
                break;
            case '30days':
                $startDate = Carbon::now()->subDays(30);
                $dateFormat = '%Y-%m-%d';
                $labelFormat = 'M d';
                break;
            case '12weeks':
                $startDate = Carbon::now()->subWeeks(12);
                $dateFormat = '%Y-%u';
                $labelFormat = 'W';
                break;
            case '12months':
                $startDate = Carbon::now()->subMonths(12);
                $dateFormat = '%Y-%m';
                $labelFormat = 'M Y';
                break;
            case 'year':
                $startDate = Carbon::now()->subYears(3);
                $dateFormat = '%Y';
                $labelFormat = 'Y';
                break;
            default:
                $startDate = Carbon::now()->subDays(30);
                $dateFormat = '%Y-%m-%d';
                $labelFormat = 'M d';
        }

        // ===== OVERVIEW STATS =====
        $totalPosts = Post::count();
        $publishedPosts = Post::where('is_published', true)->count();
        $totalViews = Post::sum('views_count');
        $totalUniqueVisitors = PostView::distinct('ip_address')->count('ip_address');
        
        $todayViews = PostView::whereDate('created_at', Carbon::today())->count();
        $yesterdayViews = PostView::whereDate('created_at', Carbon::yesterday())->count();
        $thisWeekViews = PostView::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $thisMonthViews = PostView::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->count();

        // ===== VIEWS OVER TIME (Line Chart) =====
        $viewsOverTime = PostView::where('created_at', '>=', $startDate)
            ->select(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as date_group"), DB::raw('COUNT(*) as views'))
            ->groupBy('date_group')
            ->orderBy('date_group')
            ->get();

        // Fill in missing dates for day-based periods
        $viewsChartLabels = [];
        $viewsChartData = [];
        
        if ($period === '7days' || $period === '30days') {
            $days = $period === '7days' ? 7 : 30;
            for ($i = $days; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $key = $date->format('Y-m-d');
                $viewsChartLabels[] = $date->format($labelFormat);
                $found = $viewsOverTime->firstWhere('date_group', $key);
                $viewsChartData[] = $found ? $found->views : 0;
            }
        } elseif ($period === '12months') {
            for ($i = 12; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $key = $date->format('Y-m');
                $viewsChartLabels[] = $date->format($labelFormat);
                $found = $viewsOverTime->firstWhere('date_group', $key);
                $viewsChartData[] = $found ? $found->views : 0;
            }
        } else {
            $viewsChartLabels = $viewsOverTime->pluck('date_group')->toArray();
            $viewsChartData = $viewsOverTime->pluck('views')->toArray();
        }

        // ===== TOP POSTS BY VIEWS (Bar Chart) =====
        $topPosts = Post::orderBy('views_count', 'desc')
            ->take(10)
            ->get(['id', 'title', 'views_count', 'slug', 'is_published', 'published_at']);

        // ===== TOP POSTS BY VIEWS IN SELECTED PERIOD =====
        $topPostsPeriod = PostView::where('post_views.created_at', '>=', $startDate)
            ->join('posts', 'posts.id', '=', 'post_views.post_id')
            ->select('posts.id', 'posts.title', 'posts.slug', DB::raw('COUNT(post_views.id) as period_views'))
            ->groupBy('posts.id', 'posts.title', 'posts.slug')
            ->orderByDesc('period_views')
            ->take(10)
            ->get();

        // ===== COUNTRY BREAKDOWN (Doughnut Chart) =====
        $countryData = PostView::whereNotNull('country')
            ->where('country', '!=', '')
            ->select('country', 'country_code', DB::raw('COUNT(*) as views'))
            ->groupBy('country', 'country_code')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        // ===== HOURLY DISTRIBUTION (Bar Chart) =====
        $hourlyData = PostView::where('created_at', '>=', $startDate)
            ->select(DB::raw("HOUR(created_at) as hour"), DB::raw('COUNT(*) as views'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $hourlyLabels = [];
        $hourlyViews = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyLabels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            $found = $hourlyData->firstWhere('hour', $h);
            $hourlyViews[] = $found ? $found->views : 0;
        }

        // ===== DEVICE / BROWSER BREAKDOWN =====
        $deviceData = PostView::whereNotNull('user_agent')
            ->where('created_at', '>=', $startDate)
            ->select('user_agent', DB::raw('COUNT(*) as views'))
            ->groupBy('user_agent')
            ->get();

        $devices = ['Desktop' => 0, 'Mobile' => 0, 'Tablet' => 0, 'Other' => 0];
        foreach ($deviceData as $row) {
            $ua = strtolower($row->user_agent);
            if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
                if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
                    $devices['Tablet'] += $row->views;
                } else {
                    $devices['Mobile'] += $row->views;
                }
            } elseif (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
                $devices['Tablet'] += $row->views;
            } elseif (str_contains($ua, 'bot') || str_contains($ua, 'crawler') || str_contains($ua, 'spider')) {
                $devices['Other'] += $row->views;
            } else {
                $devices['Desktop'] += $row->views;
            }
        }

        // ===== RECENT VIEWS =====
        $recentViews = PostView::with(['post', 'user'])
            ->latest()
            ->take(15)
            ->get();

        // ===== DAILY AVERAGE =====
        $firstView = PostView::orderBy('created_at')->first();
        $daysActive = $firstView ? max(1, Carbon::parse($firstView->created_at)->diffInDays(Carbon::now())) : 1;
        $dailyAverage = round($totalViews / $daysActive, 1);

        // ===== GROWTH COMPARISON =====
        $currentPeriodViews = PostView::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $previousPeriodViews = PostView::whereBetween('created_at', [Carbon::now()->subDays(60), Carbon::now()->subDays(30)])->count();
        $growthPercentage = $previousPeriodViews > 0 
            ? round((($currentPeriodViews - $previousPeriodViews) / $previousPeriodViews) * 100, 1) 
            : ($currentPeriodViews > 0 ? 100 : 0);

        return view('admin.blog.analytics', compact(
            'period',
            'totalPosts',
            'publishedPosts',
            'totalViews',
            'totalUniqueVisitors',
            'todayViews',
            'yesterdayViews',
            'thisWeekViews',
            'thisMonthViews',
            'viewsChartLabels',
            'viewsChartData',
            'topPosts',
            'topPostsPeriod',
            'countryData',
            'hourlyLabels',
            'hourlyViews',
            'devices',
            'recentViews',
            'dailyAverage',
            'growthPercentage',
            'currentPeriodViews',
            'previousPeriodViews'
        ));
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
