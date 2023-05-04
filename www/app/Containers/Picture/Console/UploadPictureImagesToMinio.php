<?php

namespace App\Containers\Picture\Console;

use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UploadPictureImagesToMinio extends Command
{
    /**
     * @var string
     */
    protected $signature = 'picture:minio-upload';

    /**
     * @var string
     */
    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        $pictures = PictureModel::with('extensions')->get();

        foreach ($pictures as $picture) {
            /** @var PictureExtensionsModel $file */
            foreach ($picture->extensions as $file) {
                $fullPath = formArtFsPath($file->path);
                $pathInfo = pathinfo($file->path);
                $file = Storage::cloud()->putFileAs(
                    '/arts/' . $pathInfo['dirname'],
                    $fullPath,
                    $pathInfo['basename']
                );
                if ($file === false) {
                    echo "F";
                } else {
                    echo '.';
                }
            }

        }
    }
}
