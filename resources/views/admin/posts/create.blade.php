@extends('layouts.admin')


@section('content')

    <div class="container">

        <div class='title'>
            <h1>Nuovo post</h1>
        </div>
            
        <form action="{{route('admin.posts.store')}}" method="POST">
            @csrf    
            
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                id="title" name="title" placeholder="Inserisci il titolo del post">
                @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="published">Pubblicare?</label>
                <select class="form-control form-control-md" id="published" name="published">
                    <option value="0">Non pubblicare</option>
                    <option value="1">Pubblica</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="content">Testo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Inserisci testo del post"></textarea>
            </div>
            
            {{-- <div class="form-group">
                <label for="thumb">Immagine</label>
                <input type="data" class="form-control @error('thumb') is-invalid @enderror" id="thumb" name="thumb" placeholder="Inserisci l'url dell'immagine del fumetto">
            </div> --}}
            
            <button type="submit" class="btn btn-primary">Crea post</button> 
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