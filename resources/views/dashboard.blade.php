@extends('layouts.app')

@section('wrapper')

    {{-- @if (auth()->user()->userable_type == 'App\Models\Customer')
        @include('customer.users.dashboard')
    @else
        @include('users.dashboard')
    @endif --}}

    {{-- <div
        x-data="{ posts: [] }"
        x-init="posts = await (await fetch('https://jsonplaceholder.typicode.com/posts')).json()"
    >
        <ul>
            <template x-for="post in posts">
                <li>
                    <h4 x-text="post.title"></h4>
                    <p x-text="post.id"></p>
                    <hr>
                </li>
            </template>
        </ul>
    </div>
    <button></button> --}}
@endsection
