<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Channel;
use Illuminate\Http\Request;
use App\Http\Requests\UserUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Charts\DashboardChart;
use Carbon\Carbon;
use App\Http\Requests\CreatePost;
use App\Post;
use App\Reply;



class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function dashboard(){
        $chart = new DashboardChart;

        $days = $this->generateDateRange(Carbon::now()->subDays(30), Carbon::now());

        $posts = [];

        foreach($days as $day){
            $posts[] = Post::whereDate('created_at', $day)->where('user_id', Auth::id())->count();
        }

        $chart->dataset('Post', 'line', $posts);
        $chart->labels($days);

        return view('user.dashboard', compact('chart'));
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date){
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()){
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function newPost($channelName){
        $channel = Channel::where('name', $channelName)->first();
        return view('user.newPost', compact('channel'));
    }

    public function createPost(CreatePost $request, $channelName){
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'nullable|file',
            'content' => 'required',
        ]);
        $channel = Channel::where('name', $channelName)->first();
        $post = new Post();
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->channel_id = $channel->id;
        $post->user_id = Auth::id();
        
        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $image->move('post-images', $fileName);
            $post->image = 'post-images/' . $fileName;
        }
        
        $post->save();
        return redirect()->route('channelPosts', $channelName);
    }

    public function posts(){
        return view('user.posts');
    }

    public function postEdit($id){
        $post = Post::where('id', $id)->where('user_id', Auth::id())->first();
        return view('user.editPost', compact('post'));
    }

    public function postEditPost(CreatePost $request, $id){
        $post = Post::where('id', $id)->where('user_id', Auth::id())->first();
        $post->title = $request['title'];
        $post->content = $request['content'];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $image->move('post-images', $fileName);
            $post->image = 'post-images/' . $fileName;
        }
        $post->save();
        

        return redirect()->route('singlePost', [$post->channel->name, $id]);
    }

    public function replies(){
        $replies = Reply::where('user_id', Auth::id())->get();
        return view('user.replies', compact('replies'));
    }

    public function replyEdit($id){
        $reply = Reply::where('id', $id)->first();
        return view('user.editReply', compact('reply'));
    }

    public function replyEditPost(Request $request, $id){
        $this->validate($request, [
            'content' => 'required',
        ]);
        $reply = Reply::where('id', $id)->first();
        $reply->content = $request['content'];
        $reply->save();

        return redirect()->route('singlePost', [$reply->post->channel->name, $reply->post->id]);
    }

    public function deleteReply($id){
        $reply = Reply::where('id', $id)->where('user_id', Auth::id())->delete();
        return back();
    }

    public function profile(){
        return view('user.profile');
    }

    public function profilePost(UserUpdate $request){
        $user = Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->save();

        if($request['password'] != ""){
            if(!(Hash::check($request['password'], Auth::user()->password))){
                return redirect()->back()->with('error', "Your current password does not match with the password you provided");
            }

            if(strcmp($request['password'], $request['new_password']) == 0){
                return redirect()->back()->with('error', "New password cannot be same as your current password.");
            }

            $validation = $request->validate([
                'password' => 'required',
                'new_password' => 'required|string|min:6|confirmed'
            ]);

            $user->password = bcrypt($request['new_password']);
            $user->save();

            return redirect()->back()->with('success', "Password changed successfully.");
        }

        return back()->with('success', 'User profile updated successfully');;
    }

    public function newComment(Request $request){
        $comment = new Comment;

        $comment->post_id = $request['post'];
        $comment->user_id = Auth::id();
        $comment->content = $request['comment'];
        $comment->save();

        return back();
    }

    public function newReply(Request $request){
        $reply = new Reply;

        $reply->post_id = $request['post'];
        $reply->user_id = Auth::id();
        $reply->content = $request['replyContent'];
        $reply->save();

        return back();
    }

}
