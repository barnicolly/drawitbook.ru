@extends('layouts.base')

@push('head')
    <link rel="canonical" href="{{ route('showArticle', ['url' => $article->link]) }}">
@endpush

@section('content')
    <div class="row clearfix">
        <div class="col-md-8">
            {!! $articleBody !!}
        </div>
        <div class="col-md-4 sidebar d-none d-md-block">
            <div class="row">
                <div class="col-12">
                    {!! loadAd('sidebar') !!}
                </div>
            </div>
        </div>
    </div>
@endsection