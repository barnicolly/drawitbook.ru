<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks;

use App\Ship\Parents\Tasks\Task;

final class FormHashTagsTask extends Task
{
    public function run(array $tags): string
    {
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('#\s+#', '', (string) $tag);
            $tags[$key] = str_ireplace('-', '', $tags[$key]);
        }
        $hashTags = '#рисунки #рисункипоклеточкам';
        if ($tags) {
            $hashTags .= ' #' . implode(' #', $tags);
        }
        return $hashTags . ' #drawitbook';
    }
}
