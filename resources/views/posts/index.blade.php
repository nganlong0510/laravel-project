<!-- resources/views/posts/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class='flex justify-between'>
        <h3>List of Posts</h3>
        <button type="button" class="btn-blue" onclick="window.location='{{ route('posts.create') }}'">
            Create Post
        </button>
    </div>


    @if (session('success'))
        <div class="alert alert-success text-green-500">{{ session('success') }}</div>
    @endif
    <ul role="list" class="mt-5 divide-y divide-blue-500">
        @foreach ($posts as $post)
            <li class="flex justify-between py-3 h-full">
                <a href="{{ route('posts.show', $post) }}" class="w-full">
                    <div class="flex w-full">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $post->title }}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $post->description }}</p>
                        </div>
                    </div>
                </a>
                <div class="sm:flex sm:flex-col sm:items-end">
                    <button type="button" class="btn-outline-blue"
                        onclick="window.location='{{ route('posts.edit', $post) }}'">
                        Edit
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
