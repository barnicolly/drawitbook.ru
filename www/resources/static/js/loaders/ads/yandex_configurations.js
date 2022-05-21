export function getYandexStackGridAds(isMobileOrTablet) {
    let result;
    if (!isMobileOrTablet) {
        result = {
            'integrated-5': getYandexBlock('R-A-734726-19'),
            'integrated-12': getYandexBlock('R-A-734726-20'),
            'integrated-18': getYandexBlock('R-A-734726-21'),
            'in_stack_arts_last': getYandexBlock('R-A-734726-22'),
        };
    } else {
        result = {
            'integrated-5': getYandexBlock('R-A-734726-8'),
            'integrated-12': getYandexBlock('R-A-734726-9'),
            'integrated-18': getYandexBlock('R-A-734726-10'),
            'in_stack_arts_last': getYandexBlock('R-A-734726-15'),
        };
    }
    return result;
}

function getYandexBlock(blockId) {
    return {
        blockId: blockId,
        async: true,
    };
}
