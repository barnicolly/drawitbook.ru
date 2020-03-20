@extends('layouts.base')

@section('content')
    <div id="siteWrapper">
        @include('layouts.public.header.base')
        <main id="appWrapper">
            @yield('layout.body')
        </main>
        @include('layouts.public.footer.base')
    </div>
@endsection




