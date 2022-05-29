<?php

namespace App\Containers\Menu\Services;

use App\Containers\Menu\Models\MenuLevelsModel;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Facades\Cache;

class MenuGroupService
{

    private $routeService;

    public function __construct()
    {
        $this->routeService = (new RouteService());
    }

    public function formCategoriesGroups(string $locale): array
    {
        $cacheName = $locale . '.menu.categories';
        $results = Cache::get($cacheName);
        if (!$results) {
            $results = Cache::remember(
                $cacheName,
                config('cache.expiration'),
                function () use ($locale) {
                    return $this->getData($locale);
                }
            );
        }
        return $results;
    }

    private function getData(string $locale): array
    {
        $items = MenuLevelsModel::getAll($locale);
        $relationItemIdWithColumn = $this->getRelationItemIdWithColumn($items);
        $result = [];
        foreach ($items as $item) {
            $levelId = $item['id'];
            $parentLevelId = $item['parent_level_id'];
            $columnId = $parentLevelId
                ? $relationItemIdWithColumn[$parentLevelId]
                : $relationItemIdWithColumn[$levelId];
            $slug = $item['slug'] ?? '';
            $title = $item['customName'] ?? $item['name'] ?? '';
            if ($columnId && empty($result[$columnId])) {
                $result[$columnId] = [];
            }
            $info = [
                'link' => $slug ? $this->routeService->getRouteArtsCellTagged($slug) : '',
                'title' => $title,
                'id' => $levelId,
            ];
            if ($parentLevelId === 0) {
                $result[$columnId][$levelId] = [
                    'parent' => $info,
                    'items' => [],
                ];
            } else {
                $result[$columnId][$parentLevelId]['items'][] = $info;
            }
        }
        foreach ($result as $column => $group) {
            foreach ($group as $parentLevelId => $subGroup) {
                $titles = array_column($subGroup['items'], 'title');
                array_multisort($titles, SORT_ASC, $subGroup['items']);
                $result[$column][$parentLevelId]['items'] = $subGroup['items'];
            }
        }
        return $result;
    }

    private function getRelationItemIdWithColumn(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            if (!empty($item['column'])) {
                $result[$item['id']] = $item['column'];
            }
        }
        return $result;
    }
}
