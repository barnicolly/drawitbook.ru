<?php

namespace App\Containers\Picture\Tasks\PictureExtension;

use App\Ship\Parents\Tasks\Task;

class SetPictureExtensionsOnPicturesTask extends Task
{

    /**
     * @param array $arts
     * @param array $files
     * @return array
     */
    public function run(array $arts, array $files): array
    {
        foreach ($arts as $key => $art) {
            $artId = $art['id'];
            if (!empty($files[$artId])) {
                $artFiles = $files[$artId];
                $mainArt = null;
                $optimizedArt = null;
                foreach ($artFiles as $file) {
                    $file['fs_path'] = formArtFsPath($file['path']);
                    if ($file['ext'] === 'webp') {
                        $optimizedArt = $file;
                    } else {
                        $mainArt = $file;
                    }
                }
                $arts[$key]['images'] = [
                    'primary' => $mainArt ?? '',
                    'optimized' => $optimizedArt ?? '',
                ];
            }
        }
        return $arts;
    }
}


