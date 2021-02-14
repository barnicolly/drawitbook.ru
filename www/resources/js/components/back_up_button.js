import {debounce} from "../helpers/optimization";
import {getWindowScrollPositionTop, scrollUpPage} from "../helpers/scroll";

export default class Back_up_button {
    constructor() {
    }

    create() {
        let id = 'pageUp';
        const buttonTitle = Lang.get('js.btn_up.title');
        let html = `
            <button type="button" id="${id}" title="${buttonTitle}">

            </button>
        `;
        document.body.insertAdjacentHTML('beforeend', html);
        this.node = document.getElementById(id);
        let boundFunction = (function () {
            let scrollTop = getWindowScrollPositionTop();
            if (scrollTop > 300) {
                this.node.classList.add('show');
            } else {
                this.node.classList.remove('show');
            }
        }).bind(this);
        let func = debounce(boundFunction, 150);
        window.addEventListener("scroll", func);

        this.node.addEventListener("click", function () {
            scrollUpPage();
        });
    }
}
