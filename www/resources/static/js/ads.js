var bvw = document.getElementsByTagName("body")[0].offsetWidth;
showAds();
var turnAds = true;

function showAds() {
    if (turnAds) {
        if (bvw > 768) {
            if (document.getElementById('in_sidebar')) {

            }
        }
        if (document.getElementById('after_picture')) {

        }
        if (document.getElementById('before_stack')) {

        }
        if (document.getElementById('after_first_stack')) {

        }
        showArticleAd();
    }
}

function showArticleAd() {
    if (bvw > 768) {
        if (document.getElementById('integrated_article_2')) {

        }
        if (document.getElementById('integrated_article_7')) {

        }
        if (document.getElementById('integrated_article_12')) {

        }
    } else {
        if (document.getElementById('integrated_article_2')) {

        }
        if (document.getElementById('integrated_article_7')) {

        }
        if (document.getElementById('integrated_article_12')) {

        }
    }
}

function showStackGridAd() {
    if (turnAds) {
        if (bvw > 768) {
            if (document.getElementById('integrated_5')) {

            }
            if (document.getElementById('integrated_12')) {

            }
            if (document.getElementById('integrated_18')) {

            }
        } else {
            if (document.getElementById('integrated_5')) {

            }
            if (document.getElementById('integrated_12')) {

            }
            if (document.getElementById('integrated_18')) {

            }
        }
    }
}
