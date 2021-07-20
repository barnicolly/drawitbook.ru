export class Storage {

    constructor() {
        this.localStorageAvailable = this.checkStorageAvailable();
    }

    set(key, value) {
        if (value) {
            if (this.localStorageAvailable) {
                try {
                    if (typeof value !== 'string') {
                        value = JSON.stringify(value);
                    }
                    localStorage.setItem(key, value);
                } catch (e) {

                }
            }
        }
    }

    get(key, isObject = true) {
        let value = null;
        if (this.localStorageAvailable) {
            try {
                const storageValue = localStorage.getItem(key);
                value = isObject ? JSON.parse(storageValue) : storageValue;
            } catch (e) {
                value = isObject ? {} : '';
            }
        }
        if (value) {
            return value;
        }
        return null;
    }

    remove(key) {
        if (this.localStorageAvailable) {
            localStorage.removeItem(key);
        }
    }

    checkStorageAvailable() {
        return typeof Storage !== 'undefined';
    }

};
