@extends('layouts.app')

@section('content')
    <h1 class="text-center">Crea un post</h1>

    <form class="container" action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="form-label">Titolo</label>
            <input class="form-control"type="text" name="title">
        </div>

        <div>
            <label class="form-label" for="">Descrizione</label>
            <textarea class="form-control"name="body"></textarea>
        </div>

        <div>
            <label>Categories</label>
            <select class="form-control" name="category_id">
                <option value="">Seleziona</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-5 text-center">
            <h4><label for="">Tags:</label></h4>
            @foreach ($tags as $tag)
                <label for="">
                    <input type="checkbox" name="tags[]" value="{{$tag->id}}">
                    {{$tag->name}}
                </label>
            @endforeach
        </div>

        <div>
            <label for="">Aggiungi immagine</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <div class="text-center">
            <button type="submit" class=" mt-3 btn btn-success">Crea</button>
        </div>

    </form>
@endsection
