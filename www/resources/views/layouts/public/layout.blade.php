@extends('layouts.base')

@section('content')
    <div id="siteWrapper" class="page__inner">
        @include('layouts.public.header.index')
        <main class="page__content container">
            <div class="page-layout">
                <div class="page-layout__content">
                    <div class="form-group content">
                        @yield('breadcrumbs')
                    </div>
                    @yield('layout.content')
                </div>
                @if (!isset($hideSocial) || !$hideSocial)
                    <div class="page-layout__share">
                        <div class="theiaStickySidebar">
                            <div class="fixed-shared-block">
                                <div class="fixed-shared-block__inner"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
        @include('layouts.public.footer.index')
    </div>
@endsection
