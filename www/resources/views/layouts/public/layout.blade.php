@extends('layouts.base')

@section('content')
    <div id="siteWrapper" class="page__inner">
        @include('layouts.public.header.index')
        <main class="page__content">
            <div class="container">
                <div class="fixed-shared-block-wrapper">
                    <div class="form-group content">
                        @yield('breadcrumbs')
                    </div>
                    @yield('layout.content')
                    @if (!isset($hideSocial) || !$hideSocial)
                        <div class="fixed-shared-block">
                            <div class="fixed-shared-block__inner"></div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
        @include('layouts.public.footer.index')
    </div>
@endsection
