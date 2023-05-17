import {sendRequest} from '@js/helpers/utils';
import {getApplyedLocaleLink} from '@js/helpers/navigation';
import '@tarekraafat/autocomplete.js/dist/css/autoComplete.01.css';

export function loadAutocomplete() {
    const $autocompleteContainers = $('#autoComplete');

    if ($autocompleteContainers.length) {
        import (/* webpackChunkName: "autoComplete" */'@tarekraafat/autocomplete.js/dist/autoComplete').then(AutoComplete => {
            sendRequest('get', getApplyedLocaleLink('/search/autocomplete'), {}, function (res) {
                const config = {
                    wrapper: false,
                    selector: "#autoComplete",
                    placeHolder: "Поиск по сайту",
                    data: {
                        src: async (query) => {
                            return res.data.items;
                        },
                    },
                    resultItem: {
                        highlight: true
                    },
                    submit: true,
                    events: {
                        input: {
                            focus: () => {
                                if (autoCompleteJS.input.value.length) autoCompleteJS.start();
                            },
                        }
                    }
                };
                const autoCompleteJS = new AutoComplete.default(config);

                autoCompleteJS.input.addEventListener("selection", function (event) {
                    const feedback = event.detail;
                    $autocompleteContainers.val(feedback.selection.value).change();
                    $autocompleteContainers.closest('form').submit();
                });
            });
        });
    }
}
