const adsenseClient = 'ca-pub-1368141699085758';

export function getRuAdsenseStackLayoutAds(screenWidth) {
    let result = {};
    if (screenWidth >= 993) {
        result = {
            'before_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '1076984235',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'after_first_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '6517669710',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
        };
    } else {
        result = {
            'before_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '7389427247',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'after_first_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '8894080608',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
        };
    }
    return result;
}

export function getEnAdsenseStackLayoutAds(screenWidth) {
    let result = {};
    if (screenWidth >= 993) {
        result = {
            'before_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '2955358216',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'after_first_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '1752095368',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
        };
    } else {
        result = {
            'before_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '6894603229',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'after_first_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': adsenseClient,
                'data-ad-slot': '3146929902',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
        };
    }
    return result;
}
