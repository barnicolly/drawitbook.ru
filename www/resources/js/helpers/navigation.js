export function getLocale() {
    return $('html').attr('lang');
}

export function getApplyedLocaleLink(link) {
    const locale = getLocale();
    return `/${locale}` + link;
}
