<?php

namespace App\Containers\Menu\Tasks;

use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;

class GetSortedMenuTreeTask extends Task
{

    private RouteService $routeService;
    private GetAllMenuTask $getAllMenuTask;

    public function __construct(RouteService $routeService, GetAllMenuTask $getAllMenuTask)
    {
        $this->routeService = $routeService;
        $this->getAllMenuTask = $getAllMenuTask;
    }

    public function run(string $locale): array
    {
        $items = $this->getAllMenuTask->run($locale);
        $relationItemIdWithColumn = $this->getRelationItemIdWithColumn($items);
        $result = [];
        foreach ($items as $item) {
            $levelId = $item['id'];
            $parentLevelId = $item['parent_level_id'];
            $columnId = $parentLevelId
                ? $relationItemIdWithColumn[$parentLevelId]
                : $relationItemIdWithColumn[$levelId];
            $slug = $item['seo'];
            $title = $item['customName'] ?? $item['name'] ?? '';
            if ($columnId && empty($result[$columnId])) {
                $result[$columnId] = [];
            }
            $info = [
                'link' => $slug ? $this->routeService->getRouteArtsCellTagged($slug): '',
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


