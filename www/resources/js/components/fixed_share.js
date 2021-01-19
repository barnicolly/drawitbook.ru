import { Storage } from '@js/local_storage';
import { merge } from 'lodash';
import { reachClickBtnShareInFixedShare } from '@js/components/ya_target';

export class FixedShare {

    constructor(options = {}, onClickExtended = null) {
        //время для появления в ms после инициализации
        this.timeAppear = 4000;
        //спустя сколько дней возобновить показ после закрытия окна
        this.daysGoneAfterBlock = 3;

        this.onClickExtended = onClickExtended;

        this.classes = {
            show: 'fixed-share--shown',
        };

        this.blockDatetimeStorageKey = 'fixed_share.block_datetime';

        this.$container = null;
        this.storage = new Storage();

        this.options = merge({
            collapseText: 'Сохранить страницу',
            titleText: 'Нашли, что искали?',
            text: ' Сохрани себе на стену, чтобы не потерять.',
        }, options);
    }

    init() {
        let fullSize = true;
        if (this.storage.checkStorageAvailable()) {
            const blockDatetime = this._getBlockDatetimeFromStorage();
            const now = new Date();
            const diffInTime = now.getTime() - blockDatetime;
            const diffInDays = diffInTime / (1000 * 3600 * 24);
            if (diffInDays > this.daysGoneAfterBlock) {
                this.storage.remove(this.blockDatetimeStorageKey);
            } else {
                fullSize = false;
            }
        }
        this._initFixedShare(fullSize);
    }

    delete() {
        this.$container.remove();
    }

    _getBlockDatetimeFromStorage() {
        let blockDatetime = this.storage.get(this.blockDatetimeStorageKey, false);
        if (typeof blockDatetime === 'string') {
            blockDatetime = blockDatetime.replace(/s+/g, '');
            blockDatetime = Number(blockDatetime);
            if (isNaN(blockDatetime)) {
                blockDatetime = 0;
            }
        } else {
            blockDatetime = 0;
        }
        return blockDatetime;
    }

    _createWrapper(fullSize) {
        const collapseStyles = fullSize ? 'display: none' : '';
        const innerStyles = !fullSize ? 'display: none' : '';

        return `<div class="fixed-share">
                    <div class="fixed-share__collapse" style="${collapseStyles}">
                        <i class="fa fa-share-alt"></i>&nbsp;${this.options.collapseText}
                    </div>
                    <div class="fixed-share__inner" style="${innerStyles}">
                        <div class="fixed-share__img">
                            <img src="/build/img/accent.gif" alt="Сохрани себе на стену">
                        </div>
                        <div class="fixed-share__title">
                           ${this.options.titleText}
                        </div>
                        <div class="fixed-share__text">
                            ${this.options.text}
                        </div>
                        <div class="fixed-share__shares">
                            <div id="fixed-share"></div>
                        </div>
                        <div class="fixed-share__close-wrapper">
                            <button class="fixed-share__close-btn btn btn-link" type="button">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
    }

    _initFixedShare(fullSize = true) {
        const wrapper = this._createWrapper(fullSize);
        $('body').append(wrapper);

        this.$container = $('.fixed-share');

        import (/* webpackChunkName: "jssocials" */'jssocials/dist/jssocials-theme-minima.css');
        import (/* webpackChunkName: "jssocials" */'jssocials/dist/jssocials.min').then(_ => {
            const defaultOptions = {
                showLabel: false,
                showCount: false,
                shares: ['vkontakte', 'facebook',  'twitter','pinterest', 'telegram', 'whatsapp', 'viber'],
            };
            this.$container.find('#fixed-share')
                .jsSocials(merge(defaultOptions, {
                    url: 'https://drawitbook.ru',
                    text: 'Drawitbook.ru. Картинки для срисовки - рисуйте, делитесь с друзьями',
                }));
        });

        this.$container
            .on('click', '.fixed-share__close-btn', () => {
                const now = new Date();
                this.storage.set(this.blockDatetimeStorageKey, now.getTime());
                this.$container.find('.fixed-share__inner').hide();
                this.$container.find('.fixed-share__collapse').show();
            })
            .on('click', '.fixed-share__collapse', () => {
                this.$container.find('.fixed-share__inner').show();
                this.$container.find('.fixed-share__collapse').hide();
                this.storage.remove(this.blockDatetimeStorageKey);
            })
            .on('click', '.jssocials-share-link', () => {
                reachClickBtnShareInFixedShare();

                this.$container
                    .find('.fixed-share__close-btn')
                    .trigger('click');

                if (typeof this.onClickExtended === 'function') {
                    this.onClickExtended();
                }
            });

        setTimeout(() => {
            this.$container.addClass(this.classes.show);
        }, this.timeAppear);
    }
};
