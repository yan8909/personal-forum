@extends('layouts.admin')

@section('title')
User Replies
@endsection

@section('content')
<div class="content">
    <div class="card">
        <div class="card-header bg-light">
            User Replies
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Post</th>
                        <th>Content</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->replies as $reply)
                        <tr>
                            <td>{{ $reply->id }}</td>
                            <td class="text-nowrap"><a href="{{ route('singlePost', [$reply->post->channel->name, $reply->post->id]) }}">{{ $reply->post->title }}</a></td>
                            <td>{{ $reply->content }}</td>
                            <td>{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('editReply', $reply->id) }}" class="btn btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteReplyModal-{{ $reply->id }}">X</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach ($replies as $reply)
    <!-- Modal -->
    <div class="modal fade" id="deleteReplyModal-{{ $reply->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You are about to delete comment for post {{ $reply->post->title }}.</h5>
                </div>
                    <div class="modal-body">
                        Are you sure?
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                    <form method="POST" id="deleteReply-{{ $reply->id }}" action="{{ route('deleteReply', $reply->id) }}">@csrf
                    <button type="submit" class="btn btn-primary">Yes, delete it</button>
                    </form>
                </div>
            </div>
        </div>
  </div>
@endforeach

@endsection