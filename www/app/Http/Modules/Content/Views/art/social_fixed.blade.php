<?php
$url = urlencode(Request::url());
$socialLinks = [
    [
        'a.href' => 'http://vk.com/share.php?url=' . $url,
        'a.class' => 'm-vk',
        'svg.href' => asset('img/sprites.svg#soc_vk'),
        'svg.attrs' => 'width="20" height="12" viewBox="0 0 20 12"',
    ],
    [
        'a.href' => 'https://twitter.com/intent/tweet?url=' . $url,
        'a.class' => 'm-tw',
        'svg.href' => asset('img/sprites.svg#soc_tw'),
        'svg.attrs' => 'width="20" height="16" viewBox="0 0 20 16"',
    ],
    [
        'a.href' => 'https://www.facebook.com/sharer.php?u=' . $url,
        'a.class' => 'm-fb',
        'svg.href' => asset('img/sprites.svg#soc_fb'),
        'svg.attrs' => 'width="16" height="16" viewBox="0 0 16 16"',
    ],
    [
        'a.href' => 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&amp;st.shareUrl=' . $url,
        'a.class' => 'm-ok',
        'svg.href' => asset('img/sprites.svg#soc_ok'),
        'svg.attrs' => 'width="11" height="19" viewBox="0 0 11 19"',
    ],
];
?>

<ul class="social-icons">
    @foreach($socialLinks as $socialLink)
        <li>
            <a href="{{ $socialLink['a.href'] }}"
               target="_blank" rel="nofollow noreferrer noopener" class="soc {{ $socialLink['a.class'] }}">
                <svg role="img" {!!  $socialLink['svg.attrs'] !!}>
                    <use xlink:href="{{ $socialLink['svg.href'] }}"></use>
                </svg>
            </a>
        </li>
    @endforeach
</ul>