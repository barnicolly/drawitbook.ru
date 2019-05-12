/*
 * Share This Image - jQuery image sharing plugin
 * http://codecanyon.net/item/share-this-image-jquery-image-sharing-plugin/7416929
 * by ILLID
 */
(function ($) {
    "use strict";

    $.fn.sti = function (options) {

        var opts = $.extend({
            selector: 'img',
            dontshow: '.dontshow',
            // title: '',
            // summary: '',
            minWidth: 200,
            minHeight: 200,
            fb_app: '',
            scroll: true,
            align: {x: 'left', y: 'bottom'},
            offset: {x: 0, y: 0},
            orientation: 'vertical',
            style: 'box',
            is_mobile: false,
            always_show: false,
            primary_menu: ["facebook", "twitter", "google", "linkedin", "pinterest"],
        }, options);

        var methods = {
            setStyle: function (e) {
                var output = "", value,
                    cssStyles = ['margin-top', 'margin-bottom', 'margin-left', 'margin-right', 'position', 'top', 'bottom', 'left', 'right', 'float', 'max-width', 'width', 'height'];
                for (var i = 0; i < cssStyles.length; i++) {
                    var style = cssStyles[i];
                    if (style === "position" && e.css(style) === "static") {
                        value = "relative";
                    }
                    else if (style === "display" && e.css(style) === "inline") {
                        value = "inline-block";
                    }
                    else if (style === "display" && e.css(style) === "none") {
                        return;
                    }
                    else if (style === "width") {
                        value = '' + e.outerWidth() + 'px';
                    }
                    else if (style === "height") {
                        value = '' + e.outerHeight() + 'px';
                    }
                    else {
                        value = e.css(style);
                    }
                    output += style + ':' + value + ';';
                }
                return output;
            }, setBoxStyle: function (e) {
                var output = "", value, value_plus, box_style,
                    cssStyles = ['padding-' + opts.align.y, 'padding-' + opts.align.x];
                for (var i = 0; i < cssStyles.length; i++) {
                    var style = cssStyles[i];
                    if (style === 'padding-' + opts.align.y) {
                        value_plus = opts.offset.y;
                        box_style = opts.align.y;
                    } else {
                        value_plus = opts.offset.x;
                        box_style = opts.align.x;
                    }
                    value = parseInt(e.css(style)) + parseInt(value_plus);
                    output += box_style + ':' + value + 'px;';
                }
                return output;
            }, createImgHash: function (str) {
                var character, hash, i;
                if (!str) {
                    return "";
                }
                hash = 0;
                if (str.length === 0) {
                    return hash;
                }
                for (i = 0; i < str.length; i++) {
                    character = str[i];
                    hash = methods.hashChar(str, character, hash);
                }
                hash = Math.abs(hash) * 1.1 + "";
                return hash.substring(0, 5);
            }, hashChar: function (str, character, hash) {
                hash = (hash << 5) - hash + str.charCodeAt(character);
                return hash & hash;
            }, scrollToImage: function (el) {
                if (!opts.scroll) {
                    return;
                }
                if (location.hash === "") {
                    return;
                }
                var hash = location.hash.substring(1);
                return el.each(function () {
                    var media = $(this).data('media') ? $(this).data('media') : $(this)[0].src;
                    if (hash === methods.createImgHash(media)) {
                        $('html, body').animate({scrollTop: $(this).offset().top}, 1000);
                        return false;
                    }
                });
            }, shareButtons: function () {
                var buttonsList = '';
                for (var i = 0; i < opts.primary_menu.length; i++) {
                    var network = opts.primary_menu[i];
                    buttonsList += '<div class="sti-btn sti-' + network + '-btn" data-network="' + network + '" rel="nofollow">';
                    buttonsList += methods.getSvgIcon(network);
                    buttonsList += '</div>';
                }
                return buttonsList;
            }, showMobile: function (el) {
                var e = $(el);
                if (opts.dontshow !== '' && e.is(opts.dontshow)) return false;
                if (e.width() < opts.minWidth || e.height() < opts.minHeight) return false;
                if (e.closest('.sti').length > 0) return false;
                e.addClass('sti_reset');
                e.wrap('<div class="sti ' + opts.orientation + ' style-' + opts.style + ' sti-mobile" style="' + methods.setStyle(e) + '"></div>');
                e.after('<span class="sti-mobile-btn" style="' + methods.setBoxStyle(e) + '">' + methods.getSvgIcon('mobile') + '</span>');
                e.after('<span class="sti-share-box" style="' + methods.setBoxStyle(e) + '">' + methods.shareButtons() + '</span>');
            }, showShare: function (el) {
                var e = $(el);
                if (opts.dontshow !== '' && e.is(opts.dontshow)) return false;
                if (e.width() < opts.minWidth || e.height() < opts.minHeight) return false;
                if (e.closest('.sti').length > 0) return false;
                e.addClass('sti_reset');
                e.wrap('<div class="sti ' + opts.orientation + ' style-' + opts.style + '" style="' + methods.setStyle(e) + '"></div>');
                e.after('<div class="sti-share-box" style="' + methods.setBoxStyle(e) + '">' + methods.shareButtons() + '</div>');
            }, hideShare: function (el) {
                var e = $(el);
                e.find('.sti-share-box').remove();
                e.find('.sti_reset').unwrap().removeClass('sti_reset');
            }, linkBox: function (el, data, event) {
                if ($(event.target).closest('.sti-link-form').length) {
                    return;
                }
                var $button = $(el);
                var link = data.link;
                if ($button.find('.sti-link-form').length > 0) {
                    methods.removeLinkForm($button);
                    $button.removeClass('active');
                } else {
                    $button.append('' + '<form class="sti-link-form">' + '<label class="sti-link-label">Share This Link</label>' + '<input class="sti-link-input" type="text" value="' + link + '">' + '</form>');
                    $button.addClass('active');
                    $button.find('.sti-link-input').select();
                }
            }, emailBox: function (el, data, event) {
                var body = encodeURIComponent(methods.replaceVariables(data, opts.emailBody));
                var subject = encodeURIComponent(methods.replaceVariables(data, opts.emailSubject));
                var mailSubject = subject ? '?subject=' + subject : '';
                var mailBody = body ? (subject ? '&body=' + body : '?body=' + body) : '';
                window.open('mailto:' + mailSubject + mailBody, '_top');
            }, getSvgIcon: function (network) {
                var icon = '';
                switch (network) {
                    case"facebook":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>';
                        break;
                    case"twitter":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg>';
                        break;
                    case"google":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.37 12.93c-.73-.52-1.4-1.27-1.4-1.5 0-.43.03-.63.98-1.37 1.23-.97 1.9-2.23 1.9-3.57 0-1.22-.36-2.3-1-3.05h.5c.1 0 .2-.04.28-.1l1.36-.98c.16-.12.23-.34.17-.54-.07-.2-.25-.33-.46-.33H7.6c-.66 0-1.34.12-2 .35-2.23.76-3.78 2.66-3.78 4.6 0 2.76 2.13 4.85 5 4.9-.07.23-.1.45-.1.66 0 .43.1.83.33 1.22h-.08c-2.72 0-5.17 1.34-6.1 3.32-.25.52-.37 1.04-.37 1.56 0 .5.13.98.38 1.44.6 1.04 1.84 1.86 3.55 2.28.87.23 1.82.34 2.8.34.88 0 1.7-.1 2.5-.34 2.4-.7 3.97-2.48 3.97-4.54 0-1.97-.63-3.15-2.33-4.35zm-7.7 4.5c0-1.42 1.8-2.68 3.9-2.68h.05c.45 0 .9.07 1.3.2l.42.28c.96.66 1.6 1.1 1.77 1.8.05.16.07.33.07.5 0 1.8-1.33 2.7-3.96 2.7-1.98 0-3.54-1.23-3.54-2.8zM5.54 3.9c.33-.38.75-.58 1.23-.58h.05c1.35.05 2.64 1.55 2.88 3.35.14 1.02-.08 1.97-.6 2.55-.32.37-.74.56-1.23.56h-.03c-1.32-.04-2.63-1.6-2.87-3.4-.13-1 .08-1.92.58-2.5zM23.5 9.5h-3v-3h-2v3h-3v2h3v3h2v-3h3"/></svg>';
                        break;
                    case"linkedin":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 21.5h-5v-13h5v13zM4 6.5C2.5 6.5 1.5 5.3 1.5 4s1-2.4 2.5-2.4c1.6 0 2.5 1 2.6 2.5 0 1.4-1 2.5-2.6 2.5zm11.5 6c-1 0-2 1-2 2v7h-5v-13h5V10s1.6-1.5 4-1.5c3 0 5 2.2 5 6.3v6.7h-5v-7c0-1-1-2-2-2z"/></svg>';
                        break;
                    case"reddit":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M24 11.5c0-1.65-1.35-3-3-3-.96 0-1.86.48-2.42 1.24-1.64-1-3.75-1.64-6.07-1.72.08-1.1.4-3.05 1.52-3.7.72-.4 1.73-.24 3 .5C17.2 6.3 18.46 7.5 20 7.5c1.65 0 3-1.35 3-3s-1.35-3-3-3c-1.38 0-2.54.94-2.88 2.22-1.43-.72-2.64-.8-3.6-.25-1.64.94-1.95 3.47-2 4.55-2.33.08-4.45.7-6.1 1.72C4.86 8.98 3.96 8.5 3 8.5c-1.65 0-3 1.35-3 3 0 1.32.84 2.44 2.05 2.84-.03.22-.05.44-.05.66 0 3.86 4.5 7 10 7s10-3.14 10-7c0-.22-.02-.44-.05-.66 1.2-.4 2.05-1.54 2.05-2.84zM2.3 13.37C1.5 13.07 1 12.35 1 11.5c0-1.1.9-2 2-2 .64 0 1.22.32 1.6.82-1.1.85-1.92 1.9-2.3 3.05zm3.7.13c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm9.8 4.8c-1.08.63-2.42.96-3.8.96-1.4 0-2.74-.34-3.8-.95-.24-.13-.32-.44-.2-.68.15-.24.46-.32.7-.18 1.83 1.06 4.76 1.06 6.6 0 .23-.13.53-.05.67.2.14.23.06.54-.18.67zm.2-2.8c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm5.7-2.13c-.38-1.16-1.2-2.2-2.3-3.05.38-.5.97-.82 1.6-.82 1.1 0 2 .9 2 2 0 .84-.53 1.57-1.3 1.87z"/></svg>';
                        break;
                    case"pinterest":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.14.5C5.86.5 2.7 5 2.7 8.75c0 2.27.86 4.3 2.7 5.05.3.12.57 0 .66-.33l.27-1.06c.1-.32.06-.44-.2-.73-.52-.62-.86-1.44-.86-2.6 0-3.33 2.5-6.32 6.5-6.32 3.55 0 5.5 2.17 5.5 5.07 0 3.8-1.7 7.02-4.2 7.02-1.37 0-2.4-1.14-2.07-2.54.4-1.68 1.16-3.48 1.16-4.7 0-1.07-.58-1.98-1.78-1.98-1.4 0-2.55 1.47-2.55 3.42 0 1.25.43 2.1.43 2.1l-1.7 7.2c-.5 2.13-.08 4.75-.04 5 .02.17.22.2.3.1.14-.18 1.82-2.26 2.4-4.33.16-.58.93-3.63.93-3.63.45.88 1.8 1.65 3.22 1.65 4.25 0 7.13-3.87 7.13-9.05C20.5 4.15 17.18.5 12.14.5z"/></svg>';
                        break;
                    case"vkontakte":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.547 7h-3.29a.743.743 0 0 0-.655.392s-1.312 2.416-1.734 3.23C14.734 12.813 14 12.126 14 11.11V7.603A1.104 1.104 0 0 0 12.896 6.5h-2.474a1.982 1.982 0 0 0-1.75.813s1.255-.204 1.255 1.49c0 .42.022 1.626.04 2.64a.73.73 0 0 1-1.272.503 21.54 21.54 0 0 1-2.498-4.543.693.693 0 0 0-.63-.403h-2.99a.508.508 0 0 0-.48.685C3.005 10.175 6.918 18 11.38 18h1.878a.742.742 0 0 0 .742-.742v-1.135a.73.73 0 0 1 1.23-.53l2.247 2.112a1.09 1.09 0 0 0 .746.295h2.953c1.424 0 1.424-.988.647-1.753-.546-.538-2.518-2.617-2.518-2.617a1.02 1.02 0 0 1-.078-1.323c.637-.84 1.68-2.212 2.122-2.8.603-.804 1.697-2.507.197-2.507z"/></svg>';
                        break;
                    case"tumblr":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.5.5v5h5v4h-5V15c0 5 3.5 4.4 6 2.8v4.4c-6.7 3.2-12 0-12-4.2V9.5h-3V6.7c1-.3 2.2-.7 3-1.3.5-.5 1-1.2 1.4-2 .3-.7.6-1.7.7-3h3.8z"/></svg>';
                        break;
                    case"digg":
                        icon += '<svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><rect height="42.351" width="51.831" x="152.89" y="114.421"></rect><path d="M77.039,179.508H0v155.27h127.082V111.662H77.039V179.508z M72.396,294.889H46.298v-70.594h26.098V294.889z   " ></path><rect height="156.168" width="51.831" x="152.89" y="179.185"></rect><path d="M231.426,335.354h77.06v24.297h-77.943v43.573h105.88h22.105V180.11H231.426V335.354z M277.713,223.684   h26.125v70.599h-26.125V223.684z"></path><path d="M384.915,180.11v155.244h77.042v24.297h-77.929v43.573h105.88H512V180.11H384.915z M457.31,294.283h-26.081   v-70.599h26.081V294.283z"></path></g></svg>';
                        break;
                    case"delicious":
                        icon += '<svg enable-background="new 0 0 24 24" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M23,0.5H12c-0.3,0-0.5,0.2-0.5,0.5v10.5H1c-0.3,0-0.5,0.2-0.5,0.5v11c0,0.3,0.2,0.5,0.5,0.5h11c0.3,0,0.5-0.2,0.5-0.5V12.5  H23c0.3,0,0.5-0.2,0.5-0.5V1C23.5,0.7,23.3,0.5,23,0.5z"/></svg>';
                        break;
                    case"odnoklassniki":
                        icon += '<svg enable-background="new 0 0 30 30" version="1.1" viewBox="0 0 30 30" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M22,15c-1,0-3,2-7,2s-6-2-7-2c-1.104,0-2,0.896-2,2c0,1,0.568,1.481,1,1.734C8.185,19.427,12,21,12,21l-4.25,5.438  c0,0-0.75,0.935-0.75,1.562c0,1.104,0.896,2,2,2c1.021,0,1.484-0.656,1.484-0.656S14.993,23.993,15,24  c0.007-0.007,4.516,5.344,4.516,5.344S19.979,30,21,30c1.104,0,2-0.896,2-2c0-0.627-0.75-1.562-0.75-1.562L18,21  c0,0,3.815-1.573,5-2.266C23.432,18.481,24,18,24,17C24,15.896,23.104,15,22,15z" id="K"/><path d="M15,0c-3.866,0-7,3.134-7,7s3.134,7,7,7c3.865,0,7-3.134,7-7S18.865,0,15,0z M15,10.5c-1.933,0-3.5-1.566-3.5-3.5  c0-1.933,1.567-3.5,3.5-3.5c1.932,0,3.5,1.567,3.5,3.5C18.5,8.934,16.932,10.5,15,10.5z" id="O"/></svg>';
                        break;
                    case"email":
                        icon += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 4H2C.9 4 0 4.9 0 6v12c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.25 14.43l-3.5 2c-.08.05-.17.07-.25.07-.17 0-.34-.1-.43-.25-.14-.24-.06-.55.18-.68l3.5-2c.24-.14.55-.06.68.18.14.24.06.55-.18.68zm4.75.07c-.1 0-.2-.03-.27-.08l-8.5-5.5c-.23-.15-.3-.46-.15-.7.15-.22.46-.3.7-.14L12 13.4l8.23-5.32c.23-.15.54-.08.7.15.14.23.07.54-.16.7l-8.5 5.5c-.08.04-.17.07-.27.07zm8.93 1.75c-.1.16-.26.25-.43.25-.08 0-.17-.02-.25-.07l-3.5-2c-.24-.13-.32-.44-.18-.68s.44-.32.68-.18l3.5 2c.24.13.32.44.18.68z"/></svg>';
                        break;
                    case"link":
                        icon += '<svg enable-background="new 0 0 80 80" version="1.1" viewBox="0 0 80 80" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M29.298,63.471l-4.048,4.02c-3.509,3.478-9.216,3.481-12.723,0c-1.686-1.673-2.612-3.895-2.612-6.257   s0.927-4.585,2.611-6.258l14.9-14.783c3.088-3.062,8.897-7.571,13.131-3.372c1.943,1.93,5.081,1.917,7.01-0.025   c1.93-1.942,1.918-5.081-0.025-7.009c-7.197-7.142-17.834-5.822-27.098,3.37L5.543,47.941C1.968,51.49,0,56.21,0,61.234   s1.968,9.743,5.544,13.292C9.223,78.176,14.054,80,18.887,80c4.834,0,9.667-1.824,13.348-5.476l4.051-4.021   c1.942-1.928,1.953-5.066,0.023-7.009C34.382,61.553,31.241,61.542,29.298,63.471z M74.454,6.044   c-7.73-7.67-18.538-8.086-25.694-0.986l-5.046,5.009c-1.943,1.929-1.955,5.066-0.025,7.009c1.93,1.943,5.068,1.954,7.011,0.025   l5.044-5.006c3.707-3.681,8.561-2.155,11.727,0.986c1.688,1.673,2.615,3.896,2.615,6.258c0,2.363-0.928,4.586-2.613,6.259   l-15.897,15.77c-7.269,7.212-10.679,3.827-12.134,2.383c-1.943-1.929-5.08-1.917-7.01,0.025c-1.93,1.942-1.918,5.081,0.025,7.009   c3.337,3.312,7.146,4.954,11.139,4.954c4.889,0,10.053-2.462,14.963-7.337l15.897-15.77C78.03,29.083,80,24.362,80,19.338   C80,14.316,78.03,9.595,74.454,6.044z"/></g><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/></svg>';
                        break;
                    case"mobile":
                        icon += '<svg enable-background="new 0 0 64 64" version="1.1" viewBox="0 0 64 64" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M48,39.26c-2.377,0-4.515,1-6.033,2.596L24.23,33.172c0.061-0.408,0.103-0.821,0.103-1.246c0-0.414-0.04-0.818-0.098-1.215  l17.711-8.589c1.519,1.609,3.667,2.619,6.054,2.619c4.602,0,8.333-3.731,8.333-8.333c0-4.603-3.731-8.333-8.333-8.333  s-8.333,3.73-8.333,8.333c0,0.414,0.04,0.817,0.098,1.215l-17.711,8.589c-1.519-1.609-3.666-2.619-6.054-2.619  c-4.603,0-8.333,3.731-8.333,8.333c0,4.603,3.73,8.333,8.333,8.333c2.377,0,4.515-1,6.033-2.596l17.737,8.684  c-0.061,0.407-0.103,0.821-0.103,1.246c0,4.603,3.731,8.333,8.333,8.333s8.333-3.73,8.333-8.333C56.333,42.99,52.602,39.26,48,39.26  z"/></svg>';
                        break;
                }
                return icon;
            }, replaceVariables: function (data, sstring) {
                return sstring.replace('{{image_link}}', data.media).replace('{{page_link}}', data.link).replace('{{title}}', data.title).replace('{{summary}}', data.summary);
            }, removeLinkForm: function ($button) {
                $button.find('.sti-link-form').remove();
            }, windowSize: function (network) {
                switch (network) {
                    case"facebook":
                        return "width=670,height=320";
                        break;
                    case"twitter":
                        return "width=626,height=252";
                        break;
                    case"google":
                        return "width=520,height=550";
                        break;
                    case"linkedin":
                        return "width=620,height=450";
                        break;
                    case"delicious":
                        return "width=800,height=600";
                        break;
                    default:
                        return "width=800,height=350";
                }
            }, replaceChars: function (string) {
                return string.replace(/[`~!@#$%^&*()_|+\-=?;:'",<>\{\}\[\]\\\/]/gi, '');
            }, getSources: function (e, sourceObj) {
                var content = '';
                if (sourceObj) {
                    for (var i = 0; i < sourceObj.length; i++) {
                        var source = sourceObj[i];
                        switch (source) {
                            case'data_title':
                                content = e.data('title');
                                break;
                            case'data_summary':
                                content = e.data('summary');
                                break;
                            case'title':
                                content = e.attr('title');
                                break;
                            case'alt':
                                content = e.attr('alt');
                                break;
                            case'default_title':
                                content = opts.title;
                                break;
                            case'default_desc':
                                content = opts.summary;
                                break;
                            case'document_title':
                                content = document.title;
                                break;
                        }
                        if (content) {
                            break;
                        }
                    }
                }
                return content;
            }, shareData: function (el, network) {
                var data = {}, e = $(el).closest('.sti').find('.sti_reset');
                data.w_size = methods.windowSize(network);
                data.media = e.data('media') ? e.data('media') : e[0].src;
                data.hash = opts.scroll ? '#' + methods.createImgHash(data.media) : '';
                data.title = e.data('title') ? e.data('title') : methods.getSources(e, opts.title_source);
                data.summary = e.data('summary') ? e.data('summary') : methods.getSources(e, opts.desc_source);
                data.local = location.href.replace(/\?img.*$/, '').replace(/\&img.*$/, '').replace(/#.*$/, '');
                data.schar = (data.local.indexOf("?") != -1) ? '&' : '?';
                data.ssl = data.media.indexOf('https://') >= 0 ? '&ssl=true' : '';
                data.link = e.data('url') ? e.data('url') : data.local + data.hash;
                data.page = opts.sharer ? opts.sharer + '?url=' + encodeURIComponent(data.link) + '&img=' + data.media.replace(/^(http?|https):\/\//, '') + '&title=' + encodeURIComponent(methods.replaceChars(data.title)) + '&desc=' + encodeURIComponent(methods.replaceChars(data.summary)) + '&network=' + network + data.ssl + data.hash : data.local + data.schar + 'img=' + data.media.replace(/^(http?|https):\/\//, '') + '&title=' + encodeURIComponent(methods.replaceChars(data.title)) + '&desc=' + encodeURIComponent(methods.replaceChars(data.summary)) + '&network=' + network + data.ssl + data.hash;
                return data;
            }, share: function (network, data) {
                var url = '';
                switch (network) {
                    case"facebook":
                        url += 'http://www.facebook.com/sharer.php?u=';
                        url += encodeURIComponent(data.page);
                        break;
                    case"google":
                        url += 'https://plus.google.com/share?';
                        url += 'url=' + encodeURIComponent(data.page);
                        break;
                    case"linkedin":
                        url += 'http://www.linkedin.com/shareArticle?mini=true';
                        url += '&url=' + encodeURIComponent(data.page);
                        break;
                    case"vkontakte":
                        url += 'http://vk.com/share.php?';
                        url += 'url=' + encodeURIComponent(data.link);
                        url += '&title=' + encodeURIComponent(data.title);
                        url += '&description=' + encodeURIComponent(data.summary);
                        url += '&image=' + encodeURIComponent(data.media);
                        url += '&noparse=true';
                        break;
                    case"odnoklassniki":
                        url += 'https://connect.ok.ru/offer';
                        url += '?url=' + encodeURIComponent(data.link);
                        url += '&title=' + encodeURIComponent(data.title);
                        url += '&imageUrl=' + encodeURIComponent(data.media);
                        break;
                    case"twitter":
                        url += 'https://twitter.com/intent/tweet?';
                        url += 'text=' + encodeURIComponent(data.title);
                        url += '&url=' + encodeURIComponent(data.page);
                        if (opts.twitterVia) {
                            url += '&via=' + opts.twitterVia;
                        }
                        break;
                    case"pinterest":
                        url += 'http://pinterest.com/pin/create/button/?';
                        url += 'url=' + encodeURIComponent(data.link);
                        url += '&media=' + encodeURIComponent(data.media);
                        url += '&description=' + encodeURIComponent(data.title);
                        break;
                    case"tumblr":
                        url += 'http://www.tumblr.com/share/photo?';
                        url += 'source=' + encodeURIComponent(data.media);
                        url += '&caption=' + encodeURIComponent(data.summary);
                        url += '&click_thru=' + encodeURIComponent(data.link);
                        break;
                    case"reddit":
                        url += 'http://reddit.com/submit?';
                        url += 'url=' + encodeURIComponent(data.link);
                        url += '&title=' + encodeURIComponent(data.title);
                        url += '&text=' + encodeURIComponent(data.summary);
                        break;
                    case"digg":
                        url += 'http://digg.com/submit?phase=2&';
                        url += 'url=' + encodeURIComponent(data.link);
                        url += '&title=' + encodeURIComponent(data.title);
                        url += '&bodytext=' + encodeURIComponent(data.summary);
                        break;
                    case"delicious":
                        url += 'http://delicious.com/post?';
                        url += 'url=' + encodeURIComponent(data.link);
                        url += '&title=' + encodeURIComponent(data.title);
                        break;
                }
                methods.openPopup(url, data.w_size);
            }, openPopup: function (url, w_size) {
                window.open(url, 'Share This Image', w_size + ',status=0,toolbar=0,menubar=0,scrollbars=1');
            }
        };
        if (!opts.is_mobile) {
            if (opts.always_show) {
                this.each(function () {
                    methods.showShare(this);
                });
            } else {
                $(document).on('mouseenter', opts.selector, function (e) {
                    e.preventDefault();
                    methods.showShare(this);
                });
                $(document).on('mouseleave', '.sti', function (e) {
                    e.preventDefault();
                    methods.hideShare(this);
                });
            }
        } else {
            this.each(function () {
                methods.showMobile(this);
            });
            $('.sti-mobile-btn').on('click', function (e) {
                e.preventDefault();
                $(this).closest('.sti').addClass('sti-mobile-show');
            });
            $(opts.selector).on('click', function (e) {
                $(this).closest('.sti').removeClass('sti-mobile-show');
            });
        }
        $(document).on('click', '.sti-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var network = $(this).data('network');
            var data = methods.shareData(this, network);
            if (network === 'link') {
                methods.linkBox(this, data, e);
            } else if (network === 'email') {
                methods.emailBox(this, data, e);
            } else {
                methods.share(network, data);
            }
        });
        $(document).on('click', function (e) {
            if ($(document).find('.sti-link-form').length > 0) {
                $('.sti-link-btn').each(function () {
                    $(this).find('.sti-link-form').remove();
                    $(this).removeClass('active');
                });
            }
        });
        methods.scrollToImage(this);
    };

}(jQuery));
