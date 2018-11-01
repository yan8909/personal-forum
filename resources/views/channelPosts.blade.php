@extends('layouts.master')
@section('content')
<!-- Page Header -->
<header class="masthead" >
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>{{ $channel->name }}</h1>
                    @if ($channel->description)
                        <span class="subheading">{{ $channel->description }}</span>
                    @endif
                    @if(Auth::check())
                        <a href="{{ route('newPost', $channel->name) }}" class="btn btn-primary mt-3">New Post</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-10 mx-auto">
                <div class="post-preview">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Replies</th>
                                    <th>Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td class="align-middle"><a href="{{ route('singlePost', [$post->channel->name, $post->id]) }}">{{ $post->title }}</a></td>
                                        <td class="align-middle">{{ $post->replies->count() }}</td>
                                        <td class="align-middle">
                                            {{ $post->user->name }} <br>
                                            {{ date_format($post->created_at, 'F d, Y') }}</td>
                                        <td>
                                            @if (Auth::user() == $post->user)
                                                <a href="{{ route('postEdit', $post->id) }}" class="btn btn-info">Edit</a>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $posts->links() }}
                
            </div>
        </div>
    </div>
    

@endsection