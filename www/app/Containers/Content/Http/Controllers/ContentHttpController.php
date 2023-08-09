<?php

declare(strict_types=1);

namespace App\Containers\Content\Http\Controllers;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Containers\Content\Actions\MainPageAction;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\Response;

final class ContentHttpController extends HttpController
{
    /**
     * @throws UnknownProperties
     *
     * @see \App\Containers\Content\Tests\Feature\Http\Controllers\ShowMainPageTest
     */
    public function showMainPage(MainPageAction $action): Response
    {
        [$viewData, $pageMetaDto] = $action->run();
        $this->setMeta($pageMetaDto->title, $pageMetaDto->description)
            ->setShareImage($pageMetaDto->shareImage);
        return response()->view('content::mainPage.index', $viewData);
    }
}
