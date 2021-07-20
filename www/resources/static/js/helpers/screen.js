const MOBILE_AND_TABLET_SCREEN_WIDTH = 992;

export function getScreenWidth() {
    return document.getElementsByTagName('body')[0].offsetWidth;
}

export function isMobileOrTablet() {
    const screenWidth = getScreenWidth();
    return screenWidth <= MOBILE_AND_TABLET_SCREEN_WIDTH;
}
