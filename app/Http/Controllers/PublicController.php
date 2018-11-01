<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Channel;
use App\User;

class PublicController extends Controller
{
    public function index(){
        $channels = Channel::all();
        return view('welcome', compact('channels'));
    }

    public function singlePost($channel, Post $post){
        $channels = Channel::all();
        return view('singlePost', compact('post', 'channels'));
    }

    public function channelPosts($channelName){
        $channels = Channel::all();
        $channel = Channel::where('name', $channelName)->first();
        $posts = Post::where('channel_id', $channel->id)->latest()->paginate(6);
        return view('channelPosts', compact('channel', 'posts', 'channels'));
    }

    

}
