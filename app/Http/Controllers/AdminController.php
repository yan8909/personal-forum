<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\User;
use App\Http\Requests\CreatePost;
use App\Http\Requests\UserUpdate;
use App\Charts\DashboardChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Facade\PayPal;
use App\Channel;
use App\Reply;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('checkRole:admin');
        $this->middleware('auth');
    }

    public function dashboard(){
        $chart = new DashboardChart;

        $days = $this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());

        $posts = [];

        foreach($days as $day){
            $posts[] = Post::whereDate('created_at', $day)->count();
        }

        $chart->dataset('Posts', 'line', $posts);
        $chart->labels($days);

        return view('admin.dashboard', compact('chart'));
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date){
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()){
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function comments(){
        $comments = Comment::all();
        return view('admin.comments', compact('comments'));
    }

    public function deleteComment($id){
        $comment = Comment::where('id', $id)->first();
        $comment->delete();
        return back();
    }

    public function posts(){
        $posts = Post::all();
        return view('admin.posts', compact('posts'));
    }

    public function users(){
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function editUser($id){
        $user = User::where('id', $id)->first();
        return view('admin.editUser', compact('user'));
    }

    public function editUserPost(UserUpdate $request, $id){
        $user = User::where('id', $id)->first();
        $user->name = $request['name'];
        $user->email = $request['email'];

        if($request['user'] == 1){
            $user->user = true;
        } elseif($request['admin'] == 1){
            $user->admin = true;
        }

        $user->save();

        return back()->with('success', 'User updated successfully');
    }

    public function deleteUser($id){
        $user = User::where('id', $id)->first();
        $user->delete();

        return back();
    }

    public function postEdit($id){
        $post = Post::where('id', $id)->first();
        return view('admin.editPost', compact('post'));
    }

    public function postEditPost(CreatePost $request, $id){
        $post = Post::where('id', $id)->first();
        $post->title = $request['title'];
        $post->content = $request['content'];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $image->move('post-images', $fileName);
            $product->image = 'post-images/' . $fileName;
        }
        $post->save();

        return redirect()->route('adminPosts');
    }

    public function deletePost($id){
        $post = Post::where('id', $id)->first();
        $post->delete();
        return back();
    }

    public function channels(){
        $channels = Channel::all();
        return view('admin.channels', compact('channels'));
    }

    public function newChannel(){
        return view('admin.newChannel');
    }

    public function newChannelPost(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            
        ]);
        $channel = new Channel();
        $channel->name = $request['name'];

        if($request['description']){
            $channel->description = $request['description'];
        }
        
        $channel->save();
        return back()->with('success', 'Channel is successfully created.');
    }

    public function channelEdit($id){
        $channel = Channel::where('id', $id)->first();
        return view('admin.editChannel', compact('channel'));
    }

    public function channelEditPost(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $channel = Channel::where('id', $id)->first();
        $channel->name = $request['name'];
        $channel->description = $request['description'];
        $channel->save();

        return redirect()->route('adminChannels');
    }

    public function deleteChannel($id){
        $channel = Channel::where('id', $id)->first();
        $channel->delete();
        return back();
    }

    public function postReplies($id){
        $post = Post::where('id', $id)->first();
        return view('admin.postReplies', compact('post'));
    }

    public function replyEdit($postId, $replyId){
        $post = Post::where('id', $postId)->first();
        $reply = Reply::where('id', $replyId)->first();
        return view('admin.editReply', compact('reply'));
    }

    public function replyEditPost(Request $request, $id){
        $this->validate($request, [
            'content' => 'required',
        ]);
        $reply = Reply::where('id', $id)->first();
        $reply->content = $request['content'];
        $reply->save();

        $post = $reply->post;

        return redirect()->route('adminPostReplies', $post->id)->with('success', "Reply updated successfully");
    }

    public function deleteReply($id){
        $reply = Reply::where('id', $id)->where('user_id', Auth::id())->delete();
        return back();
    }

}
