@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $posts->title }}</h1>
        <img class="img-fluid" src="{{asset("storage/$posts->cover")}}" alt="immagine piatto">
        <p>
            {{ $posts->body }}
        </p>
    </div>
@endsection
