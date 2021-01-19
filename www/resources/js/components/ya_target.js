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

export function reachClickSharePageFromFixedBar() {
    reachGoal('share_page.fixed_block');
    reachClickSharePage();
}

export function reachClickBtnShareInFixedShare() {
    reachGoal('share_page.fixed_share');
    reachClickSharePage();
}

function reachClickSharePage() {
    reachGoal('share_page');
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
