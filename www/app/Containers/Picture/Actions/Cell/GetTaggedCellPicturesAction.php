<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\FormCellPageAlternativeLocaleLinksTask;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Seo\Data\Dto\BreadcrumbDto;
use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetTaggedCellPicturesAction extends Action
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly SeoService $seoService,
        private readonly FormCellPageAlternativeLocaleLinksTask $formCellPageAlternativeLocaleLinksTask,
        private readonly GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask,
        private readonly GetTagBySeoNameTask $getTagBySeoNameTask,
        private readonly CreateCellResultsAction $createCellResultsAction,
    ) {
    }

    /**
     * @return array{array, PageMetaDto}
     *
     * @throws NotFoundRelativeArts
     * @throws NotFoundTagException
     * @throws UnknownProperties
     * @throws RepositoryException
     */
    public function run(string $tag): array
    {
        $locale = app()->getLocale();
        $tagInfo = $this->getTagBySeoNameTask->run($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundTagException();
        }

        $paginator = $this->getPaginatedCellArtsByTagTask->run($tagInfo->id);
        $viewData = $this->createCellResultsAction->run($locale, $paginator);
        /** @var PaginationDto $paginationData */
        $paginationData = $viewData['paginationData'];

        $tagName = $tagInfo->name;
        $alternateLinks = $this->formCellPageAlternativeLocaleLinksTask->run($tagInfo);

        $viewData['tagName'] = $tagName;
        $viewData['alternateLinks'] = count($alternateLinks) > 1 ? $alternateLinks : [];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription(
            $paginationData->total,
            $tagName,
        );
        $pageMetaDto = new PageMetaDto(title: $title, description: $description);
        $firstArt = Arr::first($viewData['arts']);
        if ($firstArt) {
            $image = $firstArt['images']['primary'];
            $shareImage = new ShareImageDto(
                relativePath: getArtsFolder() . $image['path'],
                width: $image['width'],
                height: $image['height']
            );
            $pageMetaDto->shareImage = $shareImage;
        }
        $breadCrumbs = new Collection();
        $breadCrumbs->push(
            new BreadcrumbDto(title: __('breadcrumbs.pixel_arts'), url: $this->routeService->getRouteArtsCell()),
        );
        $breadCrumbs->push(new BreadcrumbDto(title: Str::ucfirst($tagName)));
        $viewData['breadcrumbs'] = $breadCrumbs;
        return [$viewData, $pageMetaDto];
    }
}
