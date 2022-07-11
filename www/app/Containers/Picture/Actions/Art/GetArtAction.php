<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsByPictureIdsTask;
use App\Containers\Seo\Dto\ShareImageDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Actions\GetPopularTagsAction;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;

class GetArtAction extends Action
{

    private ArtsService $artsService;
    private GetPopularTagsAction $getPopularTagsAction;
    private GetRelativeArtsAction $getRelativeArtsAction;
    private SeoService $seoService;
    private TagsService $tagsService;
    private RouteService $routeService;
    private GetPictureTagsByPictureIdsTask $getPictureTagsByPictureIdsTask;

    /**
     * @param ArtsService $artsService
     * @param GetPopularTagsAction $getPopularTagsAction
     * @param GetRelativeArtsAction $getRelativeArtsAction
     * @param SeoService $seoService
     * @param TagsService $tagsService
     * @param RouteService $routeService
     * @param GetPictureTagsByPictureIdsTask $getPictureTagsByPictureIdsTask
     */
    public function __construct(
        ArtsService $artsService,
        GetPopularTagsAction $getPopularTagsAction,
        GetRelativeArtsAction $getRelativeArtsAction,
        SeoService $seoService,
        TagsService $tagsService,
        RouteService $routeService,
        GetPictureTagsByPictureIdsTask $getPictureTagsByPictureIdsTask
    ) {
        $this->artsService = $artsService;
        $this->getPopularTagsAction = $getPopularTagsAction;
        $this->getRelativeArtsAction = $getRelativeArtsAction;
        $this->seoService = $seoService;
        $this->tagsService = $tagsService;
        $this->routeService = $routeService;
        $this->getPictureTagsByPictureIdsTask = $getPictureTagsByPictureIdsTask;
    }

    /**
     * @param int $artId
     * @return array
     * @throws NotFoundPicture
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(int $artId): array
    {
        $art = $this->artsService->getById($artId);
        $locale = app()->getLocale();
        $artTags = $this->getPictureTagsByPictureIdsTask->run([$artId], false, $locale);
        $art['tags'] = $this->prepareArtTags($artTags);
        $art = $this->seoService->setArtAlt($art);
        $alternateLinks = $this->getAlternateLinks($artId);
        $viewData = [
            'art' => $art,
            'arts' => $this->getRelativeArtsAction->run($artTags, $artId),
            'popularTags' => $this->getPopularTagsAction->run(),
            'alternateLinks' => $alternateLinks,
        ];
        [$title, $description] = $this->seoService->formTitleAndDescriptionShowArt($artId);
        $image = $art['images']['primary'];
        $shareImage = new ShareImageDto(
            relativePath: getArtsFolder() . $image['path'],
            width:        $image['width'],
            height:       $image['height']
        );
        $pageMetaDto = new PageMetaDto(
            title: $title,
            description: $description,
            shareImage: $shareImage
        );
        return [$viewData, $pageMetaDto];
    }

    private function getAlternateLinks(int $id): array
    {
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteArt($id, true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteArt($id, true, LangEnum::EN),
        ];
        return $links;
    }

    private function prepareArtTags(array $artTags): array
    {
        return $this->tagsService->setLinkOnTags($artTags);
    }

}


