@extends('layouts.base')

@section('content')
    <div id="siteWrapper" class="page__inner">
        @include('layouts.public.header.index')
        <main class="page__content">
            @yield('layout.body')
        </main>
        @include('layouts.public.footer.base')
    </div>
@endsection




