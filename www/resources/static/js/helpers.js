function debounce(f, ms) {
    let timer = null;
    return function (...args) {
        const onComplete = () => {
            f.apply(this, args);
            timer = null;
        };
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(onComplete, ms);
    };
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}