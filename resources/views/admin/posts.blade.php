@extends('layouts.admin')

@section('title')
Admin Posts
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-light">
                Posts
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Post</th>
                            <th>Author</th>
                            <th>Channel</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Replies</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td class="text-nowrap"><a href="{{ route('singlePost', [$post->channel->name, $post->id]) }}">{{ $post->title }}</a></td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->channel->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>
                                <td>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</td>
                                <td><a href="{{ route('adminPostReplies', $post->id) }}"><b>{{ $post->replies->count() }}</b></a></td>
                                <td>
                                    <a href="{{ route('adminPostEdit', $post->id) }}" class="btn btn-warning">Edit</a>
                                    <form style="display: none" method="POST" id="deletePost-{{ $post->id }}" action="{{ route('adminDeletePost', $post->id) }}">@csrf</form>
                                    <button type="button" data-toggle="modal" data-target="#deletePostModal-{{ $post->id }}" class="btn btn-danger">X</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($posts as $post)
        <!-- Modal -->
        <div class="modal fade" id="deletePostModal-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">You are about to delete {{ $post->title }}.</h5>
                    </div>
                        <div class="modal-body">
                            Are you sure?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <form method="POST" id="deletePost-{{ $post->id }}" action="{{ route('adminDeletePost', $post->id) }}">@csrf
                        <button type="submit" class="btn btn-primary">Yes, delete it</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    @endforeach

@endsection