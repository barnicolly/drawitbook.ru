<?php

namespace App\Http\Modules\Open\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use MetaTag;
use Validator;
use Breadcrumbs;
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Support\Facades\Log;

class RisunkiPoKletochkam extends Controller
{

    public function __construct()
    {
        Breadcrumbs::for('home', function ($trail) {
            $trail->push('Главная', '/');
        });

        Breadcrumbs::for('risunkiPoKletochkam', function ($trail) {
            $trail->parent('home');
            $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam');
        });

        Breadcrumbs::for('risunkiPoKletochkam.search', function ($trail) {
            $trail->parent('home');
            $trail->push('Поиск', '/risunki-po-kletochkam/search');
        });


    }

    public function tagged(string $tag)
    {
        $template = new Template();

//        $viewData['countRelatedPictures'] = $countSearchResults;
//        $viewData['relativePictures'] = $relativePictures;

        $viewData = [];
        Breadcrumbs::for('risunkiPoKletochkam.search.tagged', function ($trail, $tag) {
            $trail->parent('risunkiPoKletochkam.search');
            $trail->push($tag);
        });
        MetaTag::set('robots', 'noindex');
        return $template->loadView('Open::search.risunki_po_kletochkam.tagged', $viewData);
    }
}
