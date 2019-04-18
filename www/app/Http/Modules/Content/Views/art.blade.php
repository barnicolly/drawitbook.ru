@extends('layouts.content')

@section('content')
    <figure>
        <img class="img-responsive" src="{{ asset('art/' . $picture->path) }}">
        <figcaption>
            Belle, based on 1770’s French court fashion
        </figcaption>
        @if ($picture->tags->count())
            @foreach($picture->tags as $tag)
                <a href="" class="btn btn-default">{{ $tag->name }}</a>
            @endforeach
        @endif
    </figure>
@endsection