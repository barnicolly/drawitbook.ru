const adsenseClient = 'ca-pub-1368141699085758';

export function getRuAdsenseStackLayoutAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'before_stack': getResponsiveBlock('1076984235'),
            'after_first_stack': getResponsiveBlock('6517669710'),
        };
    } else {
        result = {
            'before_stack': getResponsiveBlock('7389427247'),
            'after_first_stack': getResponsiveBlock('8894080608'),
        };
    }
    return result;
}

export function getEnAdsenseStackLayoutAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'before_stack': getResponsiveBlock('2955358216'),
            'after_first_stack': getResponsiveBlock('1752095368'),
        };
    } else {
        result = {
            'before_stack': getResponsiveBlock('6894603229'),
            'after_first_stack': getResponsiveBlock('3146929902'),
        };
    }
    return result;
}

function getResponsiveBlock(slot) {
    return {
        'class': 'adsbygoogle',
        'data-ad-client': adsenseClient,
        'data-ad-slot': slot,
        'data-full-width-responsive': 'true',
        'data-ad-format': 'auto',
        'style': 'display: block',
    };
}
