export function getWindowScrollPositionTop() {
    let doc = document.documentElement;
    return (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
}

export function scrollUpPage() {
    window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth'
    });
}
