<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Actions\Art\GetInterestingArtsAction;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Seo\Tasks\GetDefaultShareImageTask;
use App\Containers\Tag\Actions\GetPopularTagsAction;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SearchPageAction extends Action
{
    private RouteService $routeService;
    private GetPopularTagsAction $getPopularTagsAction;
    private TranslationService $translationService;
    private SearchPicturesAction $searchPicturesAction;
    private GetDefaultShareImageTask $getDefaultShareImageTask;
    private GetInterestingArtsAction $getInterestingArtsAction;

    public function __construct(
        RouteService $routeService,
        TranslationService $translationService,
        GetPopularTagsAction $getPopularTagsAction,
        SearchPicturesAction $searchPicturesAction,
        GetDefaultShareImageTask $getDefaultShareImageTask,
        GetInterestingArtsAction $getInterestingArtsAction
    ) {
        $this->routeService = $routeService;
        $this->getPopularTagsAction = $getPopularTagsAction;
        $this->translationService = $translationService;
        $this->searchPicturesAction = $searchPicturesAction;
        $this->getDefaultShareImageTask = $getDefaultShareImageTask;
        $this->getInterestingArtsAction = $getInterestingArtsAction;
    }

    /**
     * @param SearchDto $searchDto
     * @return array{array, PageMetaDto}
     * @throws UnknownProperties
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(SearchDto $searchDto): array
    {
        $paginator = $this->searchPicturesAction->run($searchDto);
        $paginationData = PaginationDto::createFromPaginator($paginator);

        $relativeArts = $paginator->getCollection()->toArray();

        if (!$relativeArts) {
            $viewData['popularArts'] = $this->getInterestingArtsAction->run(0, 10);
            $viewData['popularTags'] = $this->getPopularTagsAction->run();
        }
        $viewData['alternateLinks'] = $this->getAlternateLinks();
        $viewData['searchQuery'] = $searchDto->query;
        $viewData['filters'] = $searchDto->toArray();
        $viewData['arts'] = $relativeArts;
        $viewData['paginationData'] = $paginationData;

        $locale = app()->getLocale();
        $viewData['leftArtsText'] = $paginator->hasMorePages()
            ? $this->translationService->getPluralForm($paginationData->left, LangEnum::fromValue($locale))
            : null;
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


