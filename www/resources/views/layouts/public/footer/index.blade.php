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
        <div class="form-group content footer-end-block">
            <div class="footer-end-block__text">
                <span class="footer__app-name text-uppercase">DRAWITBOOK.COM</span> {{ date('Y') }}г.
                {!! __('pages.layout.footer.copyright') !!}
            </div>
            <div class="footer-end-block__lang-switcher lang-switcher">
                <div class="lang-switcher" id="lang-switch">
                    <div class="lang-switcher__text">
                        <p>
                            {{ __('pages.layout.footer.switch_lang') }}:
                        </p>
                    </div>
                    <div class="lang-switcher__options">
                        @foreach($languages as $language)
                            <img src="{{ buildUrl('img/flags/' . $language['src']) }}"
                                 title="{{ $language['title'] }}"
                                 class="lang-switcher__option {{ $language['selected'] ? 'lang-switcher__option-active': '' }}"
                                 data-lang="{{ $language['lang'] }}">
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>
