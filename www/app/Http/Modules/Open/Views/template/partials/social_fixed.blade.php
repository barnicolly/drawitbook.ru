<?php
$url = urlencode(Request::url());
$socialLinks = [
    [
        'a.href' => 'http://vk.com/share.php?url=' . $url,
        'a.class' => 'm-vk',
        'svg.href' => buildUrl('sprite.svg') . '#social_vk',
    ],
    [
        'a.href' => 'https://twitter.com/intent/tweet?url=' . $url,
        'a.class' => 'm-tw',
        'svg.href' => buildUrl('sprite.svg') . '#social_tw',
    ],
    [
        'a.href' => 'https://www.facebook.com/sharer.php?u=' . $url,
        'a.class' => 'm-fb',
        'svg.href' => buildUrl('sprite.svg') . '#social_fb',
    ],
    [
        'a.href' => 'https://connect.ok.ru/offer?url=' . $url,
        'a.class' => 'm-ok',
        'svg.href' => buildUrl('sprite.svg') . '#social_ok',
    ],
];
?>

<ul class="social-icons">
    @foreach($socialLinks as $socialLink)
        <li>
            <a href="{{ $socialLink['a.href'] }}"
               target="_blank" rel="nofollow noreferrer noopener" class="soc {{ $socialLink['a.class'] }}">
                <svg role="img" width="25" height="25" viewBox="0 0 25 25">
                    <use xlink:href="{{ $socialLink['svg.href'] }}"></use>
                </svg>
            </a>
        </li>
    @endforeach
</ul>
