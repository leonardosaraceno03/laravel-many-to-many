@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Lista dei post</h1>
        <button class="btn btn-success">
            <a class="text-white" href="{{ route('admin.post.create') }}">Crea nuovo post</a>
        </button>
    </div>


    <div class="container">

        @foreach ($posts as $elem)
            <div class="mt-3">
                <h3>{{ $elem->title }}</h3>
                <div>{{ $elem->body }}</div>
                @if ($elem->category)
                    <h5>La categoria è: {{ $elem->category->name }}</h5>
                @endif
            </div>

            +
            @foreach ($elem->tags as $tag)
                <ul>
                    <li>{{ $tag->name }}</li>
                </ul>
            @endforeach


            <div class="d-flex justify-items-between">
                <a href="{{ route('admin.post.show', $elem->id) }}">
                    <button class="btn btn-primary btn-sm me-4">
                        VISUALIZZA
                    </button>
                </a>
                <a href="{{ route('admin.post.edit', $elem->id) }}">
                    <button class="btn btn-primary btn-sm mx-2">
                        MODIFICA
                    </button>
                </a>
                <form action="{{ route('admin.post.destroy', $elem->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-primary btn-sm" type="submit">
                        ELIMINA
                    </button>
                </form>
            </div>
        @endforeach

    </div>
@endsection
