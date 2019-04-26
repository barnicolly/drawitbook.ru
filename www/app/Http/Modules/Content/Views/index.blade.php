@extends('layouts.base')

@section('content')
    <style>
        body {
            /*background: url(//subtlepatterns.com/patterns/scribble_light.png);*/
            font-family: Calluna, Arial, sans-serif;
            /*min-height: 1000px;*/
        }

        #columns {
            column-width: 320px;
            column-gap: 15px;
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
        }

        div#columns figure {
            background: #fefefe;
            border: 2px solid #fcfcfc;
            box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
            margin: 0 2px 15px;
            padding: 5px;
            padding-bottom: 5px;
            transition: opacity .4s ease-in-out;
            display: inline-block;
            column-break-inside: avoid;
        }

        div#columns figure img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        div#columns figure figcaption {
            font-size: .9rem;
            color: #444;
            line-height: 1.5;
        }

        div#columns small {
            font-size: 1rem;
            float: right;
            text-transform: uppercase;
            color: #aaa;
        }

        div#columns small a {
            color: #666;
            text-decoration: none;
            transition: .4s color;
        }

        figure {
            cursor: pointer;
        }

        @media screen and (max-width: 750px) {
            #columns {
                column-gap: 0px;
            }

            #columns figure {
                width: 100%;
            }
        }
    </style>

    <div id="columns">
        @foreach($pictures as $picture)
            <figure style="position: relative">
                <a href="{{ route('art', ['id' => $picture->id]) }}" title="">
                    <img src="{{ asset('arts/' . $picture->path) }}">
                </a>
                <div style="position: absolute; bottom: 5px; right: 5px">
                    <button type="button" class="btn btn-link rate-button like" title="Нравится">
                        <svg role="img" xmlns="http://www.w3.org/2000/svg" width="23" height="32" viewBox="0 0 23 32">
                            <use xlink:href="{{ asset('img/sprites.svg#like') }}"></use>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-link rate-button dislike" title="Не нравится">
                        <svg role="img" xmlns="http://www.w3.org/2000/svg" width="23" height="32" viewBox="0 0 23 32">
                            <use xlink:href="{{ asset('img/sprites.svg#dislike') }}"></use>
                        </svg>
                    </button>
                </div>
                @if($picture->description)
                    <figcaption>
                        {{ $picture->description }}
                    </figcaption>
                @endif
            </figure>

            {{--<img src="{{ asset('art/' . $picture->path) }}">--}}
            @if ($picture->tags->count())
                @foreach($picture->tags as $tag)
                    <a href="" class="btn btn-default">{{ $tag->name }}</a>
                @endforeach
            @endif
        @endforeach
    </div>
@endsection


