@extends('admin.layout')

@section('content')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

{{-- Page Header --}}
<div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            Blog Analytics
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Track visitor engagement and blog performance</p>
    </div>
    <div class="flex items-center gap-3">
        {{-- Period Filter --}}
        <form method="GET" action="{{ route('admin.blog.analytics') }}" class="flex items-center gap-2">
            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Period:</label>
            <select name="period" onchange="this.form.submit()"
                class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm cursor-pointer">
                <option value="7days" {{ $period === '7days' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="30days" {{ $period === '30days' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="12weeks" {{ $period === '12weeks' ? 'selected' : '' }}>Last 12 Weeks</option>
                <option value="12months" {{ $period === '12months' ? 'selected' : '' }}>Last 12 Months</option>
                <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Yearly</option>
            </select>
        </form>
        <a href="{{ route('admin.blog.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
            ← Back to Blog
        </a>
    </div>
</div>

{{-- ===== STAT CARDS ROW ===== --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    {{-- Total Views --}}
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 group hover:shadow-md transition-shadow duration-300">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-bl-full"></div>
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            @if($growthPercentage != 0)
                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $growthPercentage > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400' : 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400' }}">
                    {{ $growthPercentage > 0 ? '+' : '' }}{{ $growthPercentage }}%
                </span>
            @endif
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($totalViews) }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Views</p>
    </div>

    {{-- Today Views --}}
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 group hover:shadow-md transition-shadow duration-300">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-bl-full"></div>
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs text-gray-400 dark:text-gray-500">Yesterday: {{ $yesterdayViews }}</span>
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($todayViews) }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Today's Views</p>
    </div>

    {{-- Unique Visitors --}}
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 group hover:shadow-md transition-shadow duration-300">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-purple-500/10 to-transparent rounded-bl-full"></div>
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($totalUniqueVisitors) }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Unique Visitors</p>
    </div>

    {{-- Daily Average --}}
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 group hover:shadow-md transition-shadow duration-300">
        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-bl from-amber-500/10 to-transparent rounded-bl-full"></div>
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $dailyAverage }}</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daily Average</p>
    </div>
</div>

{{-- ===== QUICK STAT PILLS ===== --}}
<div class="flex flex-wrap gap-3 mb-8">
    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-full pl-3 pr-4 py-2 shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Published Posts: <strong class="text-gray-800 dark:text-white">{{ $publishedPosts }}</strong></span>
    </div>
    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-full pl-3 pr-4 py-2 shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Total Posts: <strong class="text-gray-800 dark:text-white">{{ $totalPosts }}</strong></span>
    </div>
    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-full pl-3 pr-4 py-2 shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">This Week: <strong class="text-gray-800 dark:text-white">{{ number_format($thisWeekViews) }}</strong></span>
    </div>
    <div class="flex items-center gap-2 bg-white dark:bg-gray-800 rounded-full pl-3 pr-4 py-2 shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">This Month: <strong class="text-gray-800 dark:text-white">{{ number_format($thisMonthViews) }}</strong></span>
    </div>
</div>

{{-- ===== VIEWS OVER TIME LINE CHART ===== --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Page Views Over Time</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tracking visitor engagement trends</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
            <div class="flex items-center gap-1">
                <div class="w-3 h-1 rounded-full bg-emerald-500"></div>
                <span>Views</span>
            </div>
        </div>
    </div>
    <div class="relative" style="height: 320px;">
        <canvas id="viewsOverTimeChart"></canvas>
    </div>
</div>

{{-- ===== TWO-COLUMN: TOP POSTS + COUNTRY ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Top Posts Bar Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Top Performing Posts</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All-time most viewed content</p>
        </div>
        <div class="relative" style="height: 320px;">
            <canvas id="topPostsChart"></canvas>
        </div>
    </div>

    {{-- Country Breakdown --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Audience by Country</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Where your readers come from</p>
        </div>
        @if($countryData->count() > 0)
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0" style="width: 200px; height: 200px;">
                    <canvas id="countryChart"></canvas>
                </div>
                <div class="flex-1 space-y-2 max-h-52 overflow-y-auto">
                    @foreach($countryData as $index => $country)
                        <div class="flex items-center justify-between py-1.5 px-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: {{ ['#10b981','#3b82f6','#8b5cf6','#f59e0b','#ef4444','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1'][$index] ?? '#94a3b8' }};"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $country->country }}</span>
                                <span class="text-xs text-gray-400 uppercase">({{ $country->country_code }})</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ number_format($country->views) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-gray-400 dark:text-gray-500">
                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm">No country data available yet</p>
            </div>
        @endif
    </div>
</div>

{{-- ===== TWO-COLUMN: HOURLY + DEVICE ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Hourly Distribution --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Peak Hours</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">When your audience is most active</p>
        </div>
        <div class="relative" style="height: 250px;">
            <canvas id="hourlyChart"></canvas>
        </div>
    </div>

    {{-- Device Breakdown --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Device Breakdown</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">What devices your readers use</p>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex-shrink-0" style="width: 200px; height: 200px;">
                <canvas id="deviceChart"></canvas>
            </div>
            <div class="flex-1 space-y-4">
                @php
                    $deviceIcons = [
                        'Desktop' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                        'Mobile' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                        'Tablet' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
                        'Other' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    ];
                    $deviceColors = ['Desktop' => '#3b82f6', 'Mobile' => '#10b981', 'Tablet' => '#f59e0b', 'Other' => '#94a3b8'];
                    $totalDeviceViews = array_sum($devices);
                @endphp
                @foreach($devices as $device => $count)
                    @if($count > 0)
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: {{ $deviceColors[$device] }}20; color: {{ $deviceColors[$device] }};">
                                {!! $deviceIcons[$device] !!}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $device }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $totalDeviceViews > 0 ? round(($count / $totalDeviceViews) * 100, 1) : 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full transition-all duration-500" style="width: {{ $totalDeviceViews > 0 ? ($count / $totalDeviceViews) * 100 : 0 }}%; background-color: {{ $deviceColors[$device] }};"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if($totalDeviceViews === 0)
                    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">No device data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== TOP POSTS TABLE (Period-specific) ===== --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-8">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Trending Posts</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Most viewed posts in the selected period</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rank</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Post Title</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Period Views</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topPostsPeriod as $index => $post)
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="py-3 px-4">
                            @if($index < 3)
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold
                                    {{ $index === 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400' : '' }}
                                    {{ $index === 1 ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' : '' }}
                                    {{ $index === 2 ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/50 dark:text-orange-400' : '' }}
                                ">
                                    {{ $index === 0 ? '🥇' : ($index === 1 ? '🥈' : '🥉') }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-medium pl-2">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-sm font-medium text-gray-800 dark:text-white">{{ Str::limit($post->title, 50) }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <span class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($post->period_views) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">View Post →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-400 dark:text-gray-500 text-sm">
                            No views recorded in this period
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== RECENT ACTIVITY FEED ===== --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Activity</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Latest visitor interactions with your blog</p>
    </div>
    <div class="space-y-3">
        @forelse($recentViews as $view)
            <div class="flex items-center gap-4 py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    @if($view->user)
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold text-sm border-2 border-emerald-200 dark:border-emerald-800">
                            {{ strtoupper(substr($view->user->name, 0, 1)) }}
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500 border-2 border-gray-200 dark:border-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm font-medium text-gray-800 dark:text-white">
                            {{ $view->user ? $view->user->name : 'Guest' }}
                        </span>
                        <span class="text-xs text-gray-400 dark:text-gray-500">viewed</span>
                        @if($view->post)
                            <span class="text-sm text-emerald-600 dark:text-emerald-400 font-medium truncate max-w-xs">{{ Str::limit($view->post->title, 40) }}</span>
                        @else
                            <span class="text-xs text-gray-400 italic">Deleted Post</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $view->created_at->diffForHumans() }}</span>
                        @if($view->country)
                            <span class="text-xs text-gray-400 dark:text-gray-500">• {{ $view->country }}</span>
                        @endif
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-mono">{{ $view->ip_address }}</span>
                    </div>
                </div>
                {{-- Time --}}
                <div class="flex-shrink-0 text-right hidden sm:block">
                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $view->created_at->format('M d, H:i') }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-400 dark:text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-sm">No recent activity to show</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ===== CHART.JS SCRIPTS ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared Colors
    const emerald = '#10b981';
    const emeraldLight = 'rgba(16, 185, 129, 0.1)';
    const chartColors = ['#10b981','#3b82f6','#8b5cf6','#f59e0b','#ef4444','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1'];
    
    // Detect dark mode
    const isDark = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
    const textColor = isDark ? '#9ca3af' : '#6b7280';
    const gridColor = isDark ? 'rgba(75, 85, 99, 0.3)' : 'rgba(229, 231, 235, 0.8)';

    // ===== Views Over Time Line Chart =====
    const viewsCtx = document.getElementById('viewsOverTimeChart').getContext('2d');
    const gradient = viewsCtx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

    new Chart(viewsCtx, {
        type: 'line',
        data: {
            labels: @json($viewsChartLabels),
            datasets: [{
                label: 'Page Views',
                data: @json($viewsChartData),
                borderColor: emerald,
                backgroundColor: gradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: emerald,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: emerald,
                pointHoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    titleColor: isDark ? '#f9fafb' : '#111827',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                    titleFont: { weight: '600' },
                    callbacks: {
                        label: function(ctx) {
                            return ctx.parsed.y + ' views';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 11 }, maxRotation: 45 },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor, drawBorder: false },
                    ticks: { color: textColor, font: { size: 11 }, padding: 8 },
                    border: { display: false }
                }
            }
        }
    });

    // ===== Top Posts Horizontal Bar Chart =====
    const topPostLabels = @json($topPosts->pluck('title')->map(fn($t) => Str::limit($t, 25))->toArray());
    const topPostData = @json($topPosts->pluck('views_count')->toArray());

    new Chart(document.getElementById('topPostsChart'), {
        type: 'bar',
        data: {
            labels: topPostLabels,
            datasets: [{
                label: 'Views',
                data: topPostData,
                backgroundColor: chartColors.map(c => c + '33'),
                borderColor: chartColors,
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    titleColor: isDark ? '#f9fafb' : '#111827',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: gridColor, drawBorder: false },
                    ticks: { color: textColor, font: { size: 11 } },
                    border: { display: false }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 11 } },
                    border: { display: false }
                }
            }
        }
    });

    // ===== Country Doughnut Chart =====
    @if($countryData->count() > 0)
    new Chart(document.getElementById('countryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($countryData->pluck('country')->toArray()),
            datasets: [{
                data: @json($countryData->pluck('views')->toArray()),
                backgroundColor: chartColors,
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    titleColor: isDark ? '#f9fafb' : '#111827',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = ((ctx.parsed / total) * 100).toFixed(1);
                            return ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });
    @endif

    // ===== Hourly Distribution Bar Chart =====
    const hourlyGradient = document.getElementById('hourlyChart').getContext('2d').createLinearGradient(0, 0, 0, 250);
    hourlyGradient.addColorStop(0, 'rgba(59, 130, 246, 0.7)');
    hourlyGradient.addColorStop(1, 'rgba(59, 130, 246, 0.15)');

    new Chart(document.getElementById('hourlyChart'), {
        type: 'bar',
        data: {
            labels: @json($hourlyLabels),
            datasets: [{
                label: 'Views',
                data: @json($hourlyViews),
                backgroundColor: hourlyGradient,
                borderColor: '#3b82f6',
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1f2937' : '#ffffff',
                    titleColor: isDark ? '#f9fafb' : '#111827',
                    bodyColor: isDark ? '#d1d5db' : '#4b5563',
                    borderColor: isDark ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 12,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: textColor, font: { size: 10 }, maxRotation: 45 },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor, drawBorder: false },
                    ticks: { color: textColor, font: { size: 11 } },
                    border: { display: false }
                }
            }
        }
    });

    // ===== Device Doughnut Chart =====
    const deviceLabels = @json(array_keys($devices));
    const deviceValues = @json(array_values($devices));
    const deviceColors = ['#3b82f6', '#10b981', '#f59e0b', '#94a3b8'];

    if (deviceValues.reduce((a, b) => a + b, 0) > 0) {
        new Chart(document.getElementById('deviceChart'), {
            type: 'doughnut',
            data: {
                labels: deviceLabels,
                datasets: [{
                    data: deviceValues,
                    backgroundColor: deviceColors,
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '60%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#ffffff',
                        titleColor: isDark ? '#f9fafb' : '#111827',
                        bodyColor: isDark ? '#d1d5db' : '#4b5563',
                        borderColor: isDark ? '#374151' : '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 12,
                    }
                }
            }
        });
    }
});
</script>
@endsection
