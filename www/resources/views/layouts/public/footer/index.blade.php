<footer class="footer">
    <div class="footer__line"></div>
    <div class="container">
        <div class="footer-nav">
            @foreach($groups as $group)
                <div class="footer-nav__column">
                    @include('layouts.public.footer.links_column', ['parts' => $group])
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        <div class="footer__slogan text-uppercase content">
            {!! __('pages.layout.footer.slogan') !!}
        </div>
    </div>
    <hr class="footer__delimiter">
    <div class="container">
        <div class="form-group content">
            <span class="footer__app-name text-uppercase">DRAWITBOOK.COM</span> {{ date('Y') }}г.
            {!! __('pages.layout.footer.copyright') !!}
        </div>
    </div>
</footer>
