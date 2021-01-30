import { sendRequest } from '@js/helpers/utils';
import { debounce } from '@js/helpers/optimization';
import { getApplyedLocaleLink } from '@js/helpers/navigation';

export function loadJQcloud() {
    const $jqCloudContainer = $('#tagContainer');

    if ($jqCloudContainer.length) {
        import (/* webpackChunkName: "jqcloud" */'@plugins/cloud/jqcloud.css');
        import (/* webpackChunkName: "jqcloud" */'@plugins/cloud/jqcloud-1.0.4.min').then(_ => {
            sendRequest('get', getApplyedLocaleLink('/tag/list'), {}, function (res) {
                if (res.success) {
                    var cloudTags = res.cloud_items;
                    reinitJQcloud(cloudTags);

                    function reinitJQcloud(tags) {
                        $jqCloudContainer.html('');
                        $jqCloudContainer.jQCloud(tags, {
                            classPattern: null,
                            fontSize: {
                                from: 0.1,
                                to: 0.08,
                            },
                            shape: false, // or 'rectangular'
                            autoResize: true,
                        });

                    }

                    function checkScroll() {
                        reinitJQcloud(cloudTags);
                    }

                    $(window).resize(debounce(checkScroll, 150));
                }
            });
        });
    }
}
