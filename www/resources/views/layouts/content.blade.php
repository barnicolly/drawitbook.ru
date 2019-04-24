<div class="container-fluid no-padding">
    @include('layouts/header')
    <div class="container">
        <div class="row">
            <main class="col-md-12">
                @yield('content')
            </main>
        </div>
    </div>
    @include('layouts/footer')
</div>