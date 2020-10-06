const yandexCounterName = 'yaCounter53622415';

export function reachClickFullSizeImage() {
    reachGoal('click_full_size_image');
}

function reachGoal(goal) {
    if (typeof window[yandexCounterName] !== 'undefined') {
        window[yandexCounterName].reachGoal(goal);
    }
}
