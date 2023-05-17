<!-- resources/views/posts/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class='flex justify-between'>
        <h3>{{ $post->title }}</h3>
    </div>

    <div class="space-y-6">
        <div class="border-b border-gray-900/10 pb-12">
            <div class="mt-5 space-y-5">
                <fieldset>
                    <p>{{ $post->description }}</p>
                </fieldset>
                <fieldset>
                    <label for="description" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">All
                        comments:</label>
                    @if ($post->comments->count() > 0)
                        <ul role="list" class="mt-5 divide-y divide-blue-500 w-1/3">
                            @foreach ($post->comments as $comment)
                                <li class="flex justify-between py-3 h-full">
                                    <div class="flex w-full">
                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                {{ $comment->title }}</p>
                                        </div>
                                        <div class="sm:flex sm:flex-col sm:items-end">
                                            <button type="button" class="btn-outline-blue"
                                                onclick="window.location='{{ route('comments.edit', $comment) }}'">
                                                Edit
                                            </button>
                                        </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm">No comments found.</p>
                    @endif
                    <button type="button" class="btn-outline-blue mt-2"
                        onclick="window.location='{{ route('posts.comments.create', $post) }}'">
                        Add comment
                    </button>
                </fieldset>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            @foreach ($errors->all() as $error)
                <span class="block sm:inline">{{ $error }}</span></br>
            @endforeach
        </div>
    @endif
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="button" class="btn-secondary mr-2"
                onclick="window.location='{{ route('posts.index') }}'">Back</button>
            <button type="button" class="btn-blue" onclick="window.location='{{ route('posts.edit', $post) }}'">Edit
                Post</button>
            <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete?') }}')"
                class="btn-danger">Delete Post</button>
        </form>
    </div>
@endsection
