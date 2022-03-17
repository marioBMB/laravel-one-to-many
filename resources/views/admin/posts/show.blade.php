@extends('layouts.admin')

@section('title', 'Boolpress - '.$post->title)

@section('content')
<div class="container">

    <div class="row justify-content-center my-5">
        {{-- @php if($post->published): @endphp --}}

        <div class="col-8 mb-3">
            <h2>{{$post->title}}</h2>
        </div>
        <div class="col-4">
            <h6>Creato il: {{$post->created_at}}</h6>
        </div>
            
        <p>{{$post->content}}</p>
            {{-- <img src="{{$comic->thumb}}" alt=""> --}}

         {{-- @php endif; @endphp --}}
    </div>

    <a href="{{route("admin.posts.index")}}"><button type="button" class="btn btn-primary">Indietro</button></a>
    <a href="{{route('admin.posts.destroy', $post->id)}}" class='btn btn-danger'>Elimina post</a>
</div>
  
@endsection