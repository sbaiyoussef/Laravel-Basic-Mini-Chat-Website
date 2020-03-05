@extends('layouts.app')
@section('content')
@include('message-block')

<section class="row new-post row justify-content-center">
    <div class="col-md-6 col-md-offset-3">
      <header><h3>what do you have to post!</h3>
      </header>
    <form action="{{route('post.create')}}" method="post">
         <div class="form-group">
           <textarea class="form-control" name="body" id="newpost"  rows="5" placeholder="your post"></textarea>
         </div>
         <button type="submit" class="btn btn-primary">Create Post</button>
        <input type="hidden" value="{{Session::token()}}" name="_token">
     </form>
    </div>
  </section>
  <section class="row posts row justify-content-center">
      <div class="col-md-6 col-md-offset-3">
          <header><h3>what other people say</h3>
          </header>
          @foreach ($posts as $post)
        <article class="post" data-postid="{{$post->id}}">
          <p>{{$post->body}}</p>
            <div class="info">
                Posted by {{$post->user->name}} on {{$post->created_at}}
            </div>
            <div class="interaction">
                <a href="#" class="like">{{Auth::user()->likes()->where('poste_id',$post->id)->first() ? Auth::user()->likes()->where('poste_id',$post->id)->first()->like==1 ? 'liked':'Like':'Like'}}</a>|
                <a href="#" class="like">{{Auth::user()->likes()->where('poste_id',$post->id)->first() ? Auth::user()->likes()->where('poste_id',$post->id)->first()->like==0 ? 'you don\'t liked':'disLike':'disLike'}}</a>
                @if(Auth::user()==$post->user)
                    |
            <a href="#" class="edit">edit</a>|
                  <a href="{{route('post.delete',['post_id'=>$post->id])}}">Delete</a>
                @endif    
            </div>
        </article>  
          @endforeach
      </div>
  </section>
  <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form >
            <label for="post-body">Edit the Post</label>
            <textarea class="form-control" name="post-body" id="post-body"  rows="5"></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    var token='{{Session::token()}}';
    var url='{{route('edit')}}';
    var urlLike='{{route('like')}}';

  </script>
@endsection
