@extends('layouts.admin')

@section('title', 'Boolpress - '.$post->title)

@section('content')
<div class="container">

    <div class="post-container m-5">
        {{-- @php if($post->
            published): @endphp --}}
        <div class="post-header row justify-content-between">
            <div class="col-8">
                <h2>{{$post->title}}</h2>
            </div>
            <div class="col-4">
                <h6>Creato il: {{$post->created_at}}</h6>
            </div>
        </div>

        <div class="post-content my-5">
            <p>{{$post->content}}</p>
        </div>
            {{-- <img src="{{$comic->thumb}}" alt=""> --}}

         {{-- @php endif; @endphp --}}

    <div class="post-options row">

        <a class='pr-2' href="{{route("admin.posts.index")}}"><button type="button" class="btn btn-primary">Indietro</button></a>
        
        <form action="{{route('admin.posts.destroy', $post->id)}}">
            @csrf
            @method("DELETE")
            <button onclick="return confirm('Sicuro di voler cancellare questo post?');" type='submit' class='btn btn-danger'>Elimina post</button>
        </form>
    </div>
</div>
  
@endsection