export function getYandexStackLayoutAds(screenWidth) {
    let result = {};
    if (screenWidth >= 993) {
        result = {
            // 'sidebar': 'R-A-734726-1',
            // 'after_detail_picture': 'R-A-734726-2',
            'before_stack': 'R-A-734726-4',
            'after_first_stack': 'R-A-734726-7',
        };
    } else {
        result = {
            // 'after_detail_picture': 'R-A-734726-3',
            'before_stack': 'R-A-734726-5',
            'after_first_stack': 'R-A-734726-6',
        };
    }
    return result;
}
