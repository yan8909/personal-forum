@extends('layouts.master')

@section('content')

<!-- Page Header -->
<header class="masthead" style="height:250px">
    <div class="overlay"></div>
    <div class="container" style="height:100%">
    <div class="row" style="height:100%">
        <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-heading">
            <h1>{{ $post->channel->name }}</h1>
        </div>
        </div>
    </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container" style="border-left: 0.5px solid gray; border-right: 0.5px solid gray">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @if (Auth::user() == $post->user)
                    <a href="{{ route('postEdit', $post->id) }}" class="btn btn-info float-right">Edit</a>
                @endif
                <h2>{{ $post->title }}</h2>
                <hr>
            </div>
            <div class="col-lg-8 col-md-10 mx-auto" style="background: gray; margin-bottom:20px">
                <a href="#">{{ $post->user->name }}</a><br>
                {{ date_format($post->created_at, 'F d, Y') }}
            </div>
            @if ($post->image)
                <div class="col-lg-8 col-md-10 mx-auto">
                <img src="{{ asset($post->image) }}" width="600px" alt="">
            </div>
            @endif
            
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! nl2br($post->content) !!}
                <br>
                <br>
                <p></p>
            </div>
        </div>

        <div class="row">
            @foreach($post->replies as $reply)
            <br>
                <div class="col-lg-8 col-md-10 mx-auto" style="background: gray; margin-bottom:20px">
                    {{ $reply->user->name }}<br>
                    {{ date_format($reply->created_at, 'F d, Y') }}
                </div>
                
                <div class="col-lg-8 col-md-10 mx-auto">
                    @if (Auth::user() == $reply->user)
                        <a href="{{ route('editReply', $reply->id) }}" class="btn btn-info float-right">Edit</a>
                    @endif
                    {!! nl2br($reply->content) !!}
                    <br><br><br>
                </div>
            @endforeach
                
            @if(Auth::check())
            <div class="col-lg-8 col-md-10 mx-auto">
                <form action="{{ route('newReply') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control" placeholder="" name="replyContent" id="" cols="30" rows="4"></textarea>
                        <input type="hidden" name="post" value="{{ $post->id }}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Make Reply</button>
                    </div>
                </form>
            </div>
            @endif

        </div>
    </div>
</article>



@endsection
