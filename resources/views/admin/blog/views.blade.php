@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">View Statistics</h2>
        <p class="text-gray-600 dark:text-gray-400">Detailed logs for: <span class="font-semibold text-green-600">{{ $post->title }}</span></p>
    </div>
    <div class="flex space-x-3">
        <div class="bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <span class="text-xs text-gray-500 uppercase font-bold">Total Views</span>
            <div class="text-xl font-bold text-green-600">{{ number_format($post->views_count) }}</div>
        </div>
        <a href="{{ route('admin.blog.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded transition duration-200">
            Back to Blog
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP Address</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Browser/Device</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($views as $view)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $view->created_at->format('M d, Y H:i:s') }}
                    <div class="text-xs text-gray-400">{{ $view->created_at->diffForHumans() }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 dark:text-gray-200">
                    {{ $view->ip_address }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                    @if($view->user)
                        <span class="text-green-600 font-medium">{{ $view->user->name }}</span>
                        <div class="text-xs text-gray-400">{{ $view->user->email }}</div>
                    @else
                        <span class="text-gray-400 italic">Guest</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $view->user_agent }}">
                    {{ $view->user_agent }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No views recorded yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $views->links() }}
</div>
@endsection
