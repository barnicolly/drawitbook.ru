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
    private RouteService $routeService;
    private GetPopularTagsAction $getPopularTagsAction;
    private SearchPicturesAction $searchPicturesAction;
    private GetDefaultShareImageTask $getDefaultShareImageTask;
    private GetInterestingArtsAction $getInterestingArtsAction;
    private CreateCellResultsAction $createCellResultsAction;

    public function __construct(
        RouteService $routeService,
        GetPopularTagsAction $getPopularTagsAction,
        SearchPicturesAction $searchPicturesAction,
        GetDefaultShareImageTask $getDefaultShareImageTask,
        GetInterestingArtsAction $getInterestingArtsAction,
        CreateCellResultsAction $createCellResultsAction
    ) {
        $this->routeService = $routeService;
        $this->getPopularTagsAction = $getPopularTagsAction;
        $this->searchPicturesAction = $searchPicturesAction;
        $this->getDefaultShareImageTask = $getDefaultShareImageTask;
        $this->getInterestingArtsAction = $getInterestingArtsAction;
        $this->createCellResultsAction = $createCellResultsAction;
    }

    /**
     * @param SearchDto $searchDto
     * @return array{array, PageMetaDto}
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
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::EN),
        ];
        return $links;
    }

    private function formTitleAndDescriptionSearch(): array
    {
        $title = __('seo.search.title');
        return [$title];
    }

}


