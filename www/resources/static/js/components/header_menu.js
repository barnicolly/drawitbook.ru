import { getScreenWidth } from '@js/helpers/screen';

export function initHeaderMenu($headerMenu) {
    const $hamburger = $('.hamburger');
    const $hamburgerIcon = $hamburger.find('.hamburger__icon');

    $hamburger
        .on('click', function () {
            $headerMenu.toggleClass('open');
            $('body').toggleClass('body--lock-scroll');
            if ($headerMenu.hasClass('open')) {
                $hamburgerIcon.addClass('hamburger__icon--open');
                const screenWidth = getScreenWidth();
                if (screenWidth < 768) {
                    $('.categories-dropdown').addClass('dropdown--open');
                }
            } else {
                $hamburgerIcon.removeClass('hamburger__icon--open');
            }
        })

    $headerMenu
        .on('click', '.dropdown .menu__link', function (e) {
            e.preventDefault();
            const $dropdown = $(this).closest('.dropdown');
            const $menu = $dropdown.find('.dropdown__menu');
            $menu.toggleClass('dropdown--open');
        })


}
