<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Actions\Art\GetInterestingArtsAction;
use App\Containers\Picture\Actions\Cell\CreateCellResultsAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Seo\Tasks\GetDefaultShareImageTask;
use App\Containers\Tag\Actions\GetPopularTagsAction;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SearchPageAction extends Action
{
    public function __construct(private readonly RouteService $routeService, private readonly GetPopularTagsAction $getPopularTagsAction, private readonly SearchPicturesAction $searchPicturesAction, private readonly GetDefaultShareImageTask $getDefaultShareImageTask, private readonly GetInterestingArtsAction $getInterestingArtsAction, private readonly CreateCellResultsAction $createCellResultsAction)
    {
    }

    /**
     * @return array{array, PageMetaDto}
     *
     * @throws UnknownProperties
     * @throws NotFoundRelativeArts
     * @throws RepositoryException
     */
    public function run(SearchDto $searchDto): array
    {
        $locale = app()->getLocale();
        $paginator = $this->searchPicturesAction->run($searchDto);
        $viewData = $this->createCellResultsAction->run($locale, $paginator);
        if (!$viewData['arts']) {
            $viewData['popularArts'] = $this->getInterestingArtsAction->run(0, 10);
            $viewData['popularTags'] = $this->getPopularTagsAction->run();
        }
        $viewData['alternateLinks'] = $this->getAlternateLinks();
        $viewData['searchQuery'] = $searchDto->query;
        $viewData['filters'] = $searchDto->toArray();
        [$title] = $this->formTitleAndDescriptionSearch();
        $pageMetaDto = new PageMetaDto(
            title: $title,
            shareImage: $this->getDefaultShareImageTask->run()
        );
        return [$viewData, $pageMetaDto];
    }

    private function getAlternateLinks(): array
    {
        return [[
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::RU),
        ], [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::EN),
        ]];
    }

    private function formTitleAndDescriptionSearch(): array
    {
        $title = __('seo.search.title');
        return [$title];
    }
}
