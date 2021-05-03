const adsenseClient = 'ca-pub-1368141699085758';

export function getRuAdsenseStackLayoutAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'sidebar': getResponsiveBlock('4114195518'),
            'after_detail_picture': getResponsiveBlock('6153216946'),
            'before_stack': getResponsiveBlock('1076984235'),
            'after_first_stack': getResponsiveBlock('6517669710'),
        };
    } else {
        result = {
            'after_detail_picture': getResponsiveBlock('2254318936'),
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
            'sidebar': getResponsiveBlock('5427277188'),
            'after_detail_picture': getResponsiveBlock('3567400605'),
            'before_stack': getResponsiveBlock('2955358216'),
            'after_first_stack': getResponsiveBlock('1752095368'),
        };
    } else {
        result = {
            'after_detail_picture': getResponsiveBlock('4688910585'),
            'before_stack': getResponsiveBlock('6894603229'),
            'after_first_stack': getResponsiveBlock('3146929902'),
        };
    }
    return result;
}

export function getRuAdsenseStackGridAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'integrated-5': getResponsiveBlock('3533749199'),
            'integrated-12': getResponsiveBlock('3533749199'),
            'integrated-18': getResponsiveBlock('3533749199'),
            'in_stack_arts_last': getResponsiveBlock('6159912535'),
        };
    } else {
        result = {
            'integrated-5': getResponsiveBlock('5968340840'),
            'integrated-12': getResponsiveBlock('5968340840'),
            'integrated-18': getResponsiveBlock('5968340840'),
            'in_stack_arts_last': getResponsiveBlock('8594504181'),
        };
    }
    return result;
}

export function getEnAdsenseStackGridAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'integrated-5': getResponsiveBlock('3468517621'),
            'integrated-12': getResponsiveBlock('3468517621'),
            'integrated-18': getResponsiveBlock('3468517621'),
            'in_stack_arts_last': getResponsiveBlock('1963864266'),
        };
    } else {
        result = {
            'integrated-5': getResponsiveBlock('6641475874'),
            'integrated-12': getResponsiveBlock('6641475874'),
            'integrated-18': getResponsiveBlock('6641475874'),
            'in_stack_arts_last': getResponsiveBlock('6449904189'),
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
