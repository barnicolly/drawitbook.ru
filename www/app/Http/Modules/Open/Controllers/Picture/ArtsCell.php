<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Search\SearchBySeoTag;
use App\UseCases\Search\SearchByTags;
use Illuminate\Http\Request;
use MetaTag;
use Validator;
use Breadcrumbs;
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtsCell extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        echo 123;
    }



}
