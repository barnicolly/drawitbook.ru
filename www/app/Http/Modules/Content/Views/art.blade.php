@extends('layouts.base')

@section('content')
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-2 sidebar">
                <ul class="social-icons">
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="https://twitter.com/intent/tweet?text=%D0%A1%D1%82%D1%83%D0%B4%D0%B5%D0%BD%D1%82%20%D1%82%D1%80%D0%B5%D0%B1%D1%83%D0%B5%D1%82%20%D0%BE%D1%82%20Apple%20%241%20%D0%BC%D0%BB%D1%80%D0%B4.%20%D0%A1%D0%B8%D1%81%D1%82%D0%B5%D0%BC%D0%B0%20%D0%BF%D0%BE%20%D1%80%D0%B0%D1%81%D0%BF%D0%BE%D0%B7%D0%BD%D0%B0%D0%B2%D0%B0%D0%BD%D0%B8%D1%8E%20%D0%BB%D0%B8%D1%86%20%D0%B2%20%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B5%20Apple%20%D0%BF%D0%BE%20%D0%BE%D1%88%D0%B8%D0%B1%D0%BA%D0%B5%20%D0%BF%D1%80%D0%B8%D0%BD%D1%8F%D0%BB%D0%B0%20%D0%B5%D0%B3%D0%BE%20%D0%B7%D0%B0%20%D0%B2%D0%BE%D1%80%D0%B0&url=https%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-tw">
                            <svg role="img" width="20" height="16" viewBox="0 0 20 16">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_tw') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="https://www.facebook.com/sharer.php?u=https%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-fb">
                            <svg role="img" width="16" height="16" viewBox="0 0 16 16">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_fb') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="http://vk.com/share.php?url=https%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial&title=%D0%A1%D1%82%D1%83%D0%B4%D0%B5%D0%BD%D1%82%20%D1%82%D1%80%D0%B5%D0%B1%D1%83%D0%B5%D1%82%20%D0%BE%D1%82%20Apple%20%241%20%D0%BC%D0%BB%D1%80%D0%B4.%20%D0%A1%D0%B8%D1%81%D1%82%D0%B5%D0%BC%D0%B0%20%D0%BF%D0%BE%20%D1%80%D0%B0%D1%81%D0%BF%D0%BE%D0%B7%D0%BD%D0%B0%D0%B2%D0%B0%D0%BD%D0%B8%D1%8E%20%D0%BB%D0%B8%D1%86%20%D0%B2%20%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B5%20Apple%20%D0%BF%D0%BE%20%D0%BE%D1%88%D0%B8%D0%B1%D0%BA%D0%B5%20%D0%BF%D1%80%D0%B8%D0%BD%D1%8F%D0%BB%D0%B0%20%D0%B5%D0%B3%D0%BE%20%D0%B7%D0%B0%20%D0%B2%D0%BE%D1%80%D0%B0"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-vk">
                            <svg role="img" width="20" height="12" viewBox="0 0 20 12">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_vk') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=https%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-ok">
                            <svg role="img" width="11" height="19" viewBox="0 0 11 19">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_ok') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="https://share.flipboard.com/bookmarklet/popout?v=2&title=%D0%A1%D1%82%D1%83%D0%B4%D0%B5%D0%BD%D1%82%20%D1%82%D1%80%D0%B5%D0%B1%D1%83%D0%B5%D1%82%20%D0%BE%D1%82%20Apple%20%241%20%D0%BC%D0%BB%D1%80%D0%B4.%20%D0%A1%D0%B8%D1%81%D1%82%D0%B5%D0%BC%D0%B0%20%D0%BF%D0%BE%20%D1%80%D0%B0%D1%81%D0%BF%D0%BE%D0%B7%D0%BD%D0%B0%D0%B2%D0%B0%D0%BD%D0%B8%D1%8E%20%D0%BB%D0%B8%D1%86%20%D0%B2%20%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B5%20Apple%20%D0%BF%D0%BE%20%D0%BE%D1%88%D0%B8%D0%B1%D0%BA%D0%B5%20%D0%BF%D1%80%D0%B8%D0%BD%D1%8F%D0%BB%D0%B0%20%D0%B5%D0%B3%D0%BE%20%D0%B7%D0%B0%20%D0%B2%D0%BE%D1%80%D0%B0&url=https%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-fl">
                            <svg role="img" width="16" height="16" viewBox="0 0 16 16">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_fl') }}"></use>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a target="_blank" rel="nofollow"
                           href="https://plus.google.com/share?app=110&url=http%3A%2F%2Fincrussia.ru%2Fnews%2Fstudent-trebuet-ot-apple-1-mlrd%2F%3Futm_referrer%3Dhttps%253A%252F%252Fzen.yandex.com%252F%253Ffrom%253Dspecial"
                           target="_blank" rel="nofollow noreferrer noopener" class="soc m-gp">
                            <svg role="img" width="24" height="14" viewBox="0 0 24 14">
                                <use xlink:href="{{ asset('img/sprites.svg#soc_gp') }}"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10">
                <figure>
                    <img style="margin: 0 auto; max-height: 755px" class="img-responsive"
                         src="{{ asset('arts/' . $picture->path) }}">
                    <figcaption>
                        123
                    </figcaption>
                    @if ($picture->tags->count())
                        @foreach($picture->tags as $tag)
                            <a href="" class="btn btn-default">{{ $tag->name }}</a>
                        @endforeach
                    @endif
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="columns">
                    @foreach($relativePictures as $picture)
                        <figure>
                            <a href="{{ route('art', ['id' => $picture->id]) }}" title="">
                                <img src="{{ asset('arts/' . $picture->path) }}">
                            </a>
                            {{--<img src="{{ asset('art/' . $picture->path) }}">--}}
                            @if ($picture->tags->count())
                                @foreach($picture->tags as $tag)
                                    <a href="" class="btn btn-default">{{ $tag->name }}</a>
                                @endforeach
                            @endif
                            @if($picture->description)
                                <figcaption>
                                    {{ $picture->description }}
                                </figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        sidebar
    </div>
    <style>

        .social-icons {
            list-style-type: none;
        }

        .social-icons li {
            display: block;
        }

        .social-icons li a {
            position: relative;
            height: 65px;
            line-height: 67px;
            display: block;
            text-align: center;
            color: #5c42ab;
        }

        .social-icons li a:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAYAAAABAQMAAADHB02zAAAABlBMV…BcQqtDijn8AAAAAnRSTlMATX7+8BUAAAAKSURBVAjXY2gAAACCAIHdQ2r0AAAAAElFTkSuQmCC);
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
@endsection