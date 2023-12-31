<?php

declare(strict_types=1);

namespace App\Containers\Menu\Tasks;

use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;

final class GetSortedMenuTreeTask extends Task
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly GetAllMenuTask $getAllMenuTask,
    ) {
    }

    public function run(string $locale): array
    {
        $items = $this->getAllMenuTask->run($locale);
        $relationItemIdWithColumn = $this->getRelationItemIdWithColumn($items);
        $result = [];
        foreach ($items as $item) {
            $levelId = $item['id'];
            $parentLevelId = $item['parent_level_id'] ?? 0;
            $columnId = $parentLevelId
                ? $relationItemIdWithColumn[$parentLevelId]
                : $relationItemIdWithColumn[$levelId];
            $slug = $item['seo'];
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
