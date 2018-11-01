@extends('layouts.admin')

@section('title')
Admin Channels
@endsection

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header bg-light">
                Channels  
                <a href="{{ route('newChannel') }}" class="btn btn-primary float-right">New Channel</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Channel</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($channels as $channel)
                            <tr>
                                <td>{{ $channel->id }}</td>
                                <td class="text-nowrap"><a href="{{ route('channelPosts', $channel->name) }}">{{ $channel->name }}</a></td>
                                <td>{{ \Carbon\Carbon::parse($channel->created_at)->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('adminChannelEdit', $channel->id) }}" class="btn btn-warning">Edit</a>
                                    <form style="display: none" method="POST" id="deleteChannel-{{ $channel->id }}" action="{{ route('adminDeleteChannel', $channel->id) }}">@csrf</form>
                                    <button type="button" data-toggle="modal" data-target="#deleteChannelModal-{{ $channel->id }}" class="btn btn-danger">X</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($channels as $channel)
        <!-- Modal -->
        <div class="modal fade" id="deleteChannelModal-{{ $channel->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">You are about to delete {{ $channel->name }}.</h5>
                    </div>
                        <div class="modal-body">
                            Are you sure?
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it</button>
                        <form method="POST" id="deleteChannel-{{ $channel->id }}" action="{{ route('adminDeleteChannel', $channel->id) }}">@csrf
                        <button type="submit" class="btn btn-primary">Yes, delete it</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    @endforeach

@endsection