<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Actions\GetPopularTagsAction;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Dto\PageMetaDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class GetArtAction extends Action
{
    public function __construct(
        private readonly GetPopularTagsAction $getPopularTagsAction,
        private readonly GetRelativeArtsAction $getRelativeArtsAction,
        private readonly SeoService $seoService,
        private readonly RouteService $routeService,
        private readonly GetArtByIdAction $getArtByIdAction,
    ) {
    }

    /**
     * @throws NotFoundPicture
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function run(int $artId): array
    {
        $art = $this->getArtByIdAction->run($artId, true);
        $alternateLinks = $this->getAlternateLinks($artId);
        $viewData = [
            'art' => $art,
            'arts' => $this->getRelativeArtsAction->run($art['tags'], $artId),
            'popularTags' => $this->getPopularTagsAction->run(),
            'alternateLinks' => $alternateLinks,
        ];
        [$title, $description] = $this->seoService->formTitleAndDescriptionShowArt($artId);
        $image = $art['images']['primary'];
        $shareImage = new ShareImageDto(
            relativePath: getArtsFolder() . $image['path'],
            width: $image['width'],
            height: $image['height']
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
        return [
            [
                'lang' => LangEnum::RU,
                'href' => $this->routeService->getRouteArt($id, true, LangEnum::RU),
            ],
            [
                'lang' => LangEnum::EN,
                'href' => $this->routeService->getRouteArt($id, true, LangEnum::EN),
            ],
        ];
    }
}
