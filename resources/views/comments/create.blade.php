<!-- resources/views/comments/create.blade.php -->

@extends('layouts.app')

@section('content')

    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="w-1/2">
        @csrf

        <div class="space-y-6">
            <div class="border-b border-gray-900/10 pb-12">
                <h3>Create new Comment</h3>
                <p class="mt-1 text-sm leading-6 text-gray-600">Add more comment to this post</p>

                <div class="mt-5 space-y-5">
                    <fieldset>
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <input type="text" name="title" id="title"
                                    class="form-control block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment
                            Description (optional)</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input type="text" name="description" id="description"
                                class="form-control block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                        </div>
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
            <button type="button" class="btn-secondary"
                onclick="window.location='{{ route('posts.show', $post) }}'">Cancel</button>
            <button type="submit" class="btn-blue">Create</button>
        </div>
    </form>
@endsection
