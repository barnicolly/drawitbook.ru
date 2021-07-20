export function getLocale() {
    return $('html').attr('lang').toLowerCase();
}

export function getApplyedLocaleLink(link) {
    const locale = getLocale();
    return `/${locale}` + link;
}
