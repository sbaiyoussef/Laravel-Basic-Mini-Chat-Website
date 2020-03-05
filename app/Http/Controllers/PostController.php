<?php

namespace App\Http\Controllers;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function postcreatePost(Request $request){
        $this->validate($request,[
            'body'=>'required|max:1000'
        ]);
        $post=new Post();
        $post->body=$request['body'];
        $message='there was an error';
        if($request->user()->posts()->save($post)){
         $message='Post successfully created!';
        }
        return redirect()->route('home')->with(['message'=>$message]);
    }
    public function index()
    {
        $posts=Post::orderBy('created_at','desc')->get();
        return view('home',['posts'=>$posts]);
    }
    public function deletepost($post_id){
        $post=POST::where('id',$post_id)->first();
        if(Auth::user()!=$post->user){
            return redirect()->back();
        }
        $post->delete();
         return redirect()->route('home')->with(['message'=>'successfully deleted']);
    }
    public function editpost(Request $request){
      $this->validate($request,[
         'body'=>'required'
      ]);
      $post=Post::find($request['postId']);
      $post->body=$request['body'];
      $post->update();
      return response()->json(['new_body'=>$post->body],200);
    }
    public function getAccount(){
        return view('account',['user'=>Auth::user()]);
    }
    public function postsaveaccount(Request $request){
        $this->validate($request,[
            'name'=>'required|max:120'
        ]);
        $user=Auth::user();
        $user->name=$request['name'];
        $user->update();
        $file=$request->file('image');
        $filename=$request['name'] . '-' . $user->id . '.jpg';
        if($file){
            Storage::disk('local')->put($filename,File::get($file));
        }
        return redirect()->route('account');
    }
    public function getimage($filename){
        $file=Storage::disk('local')->get($filename);
        return new Response($file,200);
    }
    public function postLike(Request $request){
        $post_id=$request['postId'];
        $is_like=$request['islike'] === 'true';
        $update=false;
        $post=Post::find($post_id);
        if(!$post){
            return null;
        }
        $user=Auth::user();
        $like=$user->likes()->where('poste_id',$post_id)->first();
        if($like){
            $already_like=$like->like;
            $update=true;
            if($already_like==$is_like){
                $like->delete();
                return null;
            }
        }
        else{
            $like=new Like();
        }
        $like->like=$is_like;
        $like->user_id=$user->id;
        $like->poste_id=$post->id;
        if($update){
            $like->update();
        }
        else{
            $like->save();
        }
        return null;
    }
}
