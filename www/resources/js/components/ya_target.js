const yandexCounterName = 'yaCounter53622415';

export function reachClickFullSizeImage() {
    reachGoal('click_full_size_image');
}

export function reachClickBtnExternalLink() {
    reachGoal('click_btn_in_new_window');
}

export function reachClickBtnFindSimilar() {
    reachGoal('click_btn_find_similar');
}

export function reachClickBtnShareVk() {
    reachGoal('share_vk');
}

export function reachClickBtnShareTelegram() {
    reachGoal('share_telegram');
}

export function reachClickBtnShareTwitter() {
    reachGoal('share_twitter');
}

export function reachClickBtnShareFacebook() {
    reachGoal('share_facebook');
}

export function reachClickBtnSharePinterest() {
    reachGoal('share_pinterest');
}

export function reachClickBtnShareWhatsapp() {
    reachGoal('share_whatsapp');
}

export function reachClickBtnShareViber() {
    reachGoal('share_viber');
}

export function reachClickBtnShareEmail() {
    reachGoal('share_email');
}

export function reachClickTagItem() {
    reachGoal('click_tag_item');
}

export function reachClickBtnRate() {
    reachGoal('click_btn_rate');
}

export function reachClickDownloadMoreBtn() {
    reachGoal('click_btn_download_more');
}

function reachGoal(goal) {
    if (typeof window[yandexCounterName] !== 'undefined') {
        window[yandexCounterName].reachGoal(goal);
    }
}
