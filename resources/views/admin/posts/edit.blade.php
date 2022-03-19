@extends('layouts.admin')


@section('content')

    <div class="container">

        <div class='post-header row justify-content-between'>
            <div class="col-auto">
                <h1>Modifica post: {{$post->title}}</h1>
            </div>
            <div class="col-auto">
                <a href="{{route('admin.posts.index')}}" class='btn btn-primary'><i class="fa fa-arrow-left" aria-hidden="true"></i> Indietro</a>
            </div>
        </div>
            
        <form action="{{route('admin.posts.update', $post->id)}}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                id="title" name="title" placeholder="Inserisci il titolo del post" value='{{ old('title')?? $post->content }}'>
                @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="published">Pubblicare?</label>
                <select class="form-control form-control-md" id="published" name="published">

                    @php $selected = old('published')?? $post->published; @endphp

                    <option value="0" {{($post->published == 0) ?? "selected"}}>Non pubblicare</option>
                    <option value="1">Pubblica</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="content">Testo</label>
                @php $content = old('content')?? $post->content; @endphp
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Inserisci testo del post">{!!$content!!}</textarea>
                {{-- non lasciare spazi se usi {+!! --}}
            </div>


            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select name="category_id" class="form-control" id="">
                    <option value="">-- seleziona categoria --</option>
        
                    @foreach ($categories as $category)
                    @php $selected = old('category_id')?? $post->category_id @endphp
                    <option value="{{$category->id}}" {{($category->id == $selected)? "selected" : ""}}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                {{-- questa gestione degli errori serve poiché potrebbe essere possibile iniettare tramite html dei valori non consentiti come option della select 
                (modificando il DOM) e facendo submit invieremmo dati che il server deve scartare --}}
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            {{-- <div class="form-group">
                <label for="thumb">Immagine</label>
                <input type="data" class="form-control @error('thumb') is-invalid @enderror" id="thumb" name="thumb" placeholder="Inserisci l'url dell'immagine del fumetto">
            </div> --}}
            
            <button type="submit" class="btn btn-success"><strong><i class="fa fa-floppy-o" aria-hidden="true"></i></strong> Modifica</button> 
        </form>

        @if ($errors->any())
        <div class='alert alert-danger'>
            
            <ul>
                @foreach($errors -> all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
@endsection