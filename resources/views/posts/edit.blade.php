<!-- resources/views/posts/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <form action="{{ route('posts.update', $post) }}" method="POST" class="w-1/2">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="border-b border-gray-900/10 pb-12">
                <h3>Edit {{ $post->title }}</h3>
                <p class="mt-1 text-sm leading-6 text-gray-600">You can edit your post below</p>

                <div class="mt-5 space-y-10">
                    <fieldset>
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-900">Title</label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <input type="text" name="title" id="title" value="{{ $post->title }}"
                                    class="form-control block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                            Description</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input type="text" name="description" id="description" value="{{ $post->description }}"
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
                onclick="window.location='{{ route('posts.index') }}'">Cancel</button>
            <button type="submit" class="btn-blue">Update</button>
        </div>
    </form>
    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')

        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete?') }}')"
            class="btn-danger">Delete Post</button>
    </form>
@endsection
