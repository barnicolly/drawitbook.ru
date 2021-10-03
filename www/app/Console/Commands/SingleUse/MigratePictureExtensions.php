<?php

namespace App\Console\Commands\SingleUse;

use App\Models\CoreModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigratePictureExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmp:migrate:picture_extensions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Миграция данных из picture в picture_extensions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = $this->formInsertData();
        if (!empty($result)) {
            $this->insertResult($result);
        }
    }

    private function formInsertData(): array
    {
        $pictures = $this->getPictures();
        $result = [];
        foreach ($pictures as $picture) {
            $picturePath = $picture['path'];
            $fileInfo = pathinfo($picturePath);
            $extension = $fileInfo['extension'];
            $webpPath = str_ireplace(".{$extension}", '.webp', $picturePath);

            $item = [
                'picture_id' => $picture['id'],
                'path' => $picturePath,
                'width' => $picture['width'],
                'height' => $picture['height'],
                'ext' => $extension,
            ];
            $result[] = $item;
            if (checkExistArt($webpPath)) {
                $item['path'] = $webpPath;
                $item['ext'] = 'webp';
                $result[] = $item;
            }
        }
        return $result;
    }

    private function insertResult(array $result): void
    {
        $chunks = array_chunk($result, 2000);
        foreach ($chunks as $chunk) {
            DB::table('picture_extensions')
                ->insert($chunk);
        }
    }

    private function getPictures(): array
    {
        $data = DB::table('picture')
            ->get()
            ->toArray();
        return CoreModel::mapToArray($data);
    }
}
