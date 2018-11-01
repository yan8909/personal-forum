@extends('layouts.admin')

@section('title')
User Post
@endsection

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header bg-light">
            User Posts
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Post</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Replies</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td class="text-nowrap"><a href="{{ route('singlePost', [$post->channel->name, $post->id]) }}">{{ $post->title }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>
                            <td>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</td>
                            <td>{{ $post->replies->count() }}</td>
                            <td>
                                <a href="{{ route('postEdit', $post->id) }}" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection