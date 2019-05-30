<?php

namespace App\UseCases\Vk;

use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Vk\Core\VkCore;

//use ;

class AttachArtToVkAlbum extends VkCore
{

    protected $_albumId;
    protected $_artId;

    public function __construct(int $albumId, int $artId)
    {
        parent::__construct();
        $this->_albumId = $albumId;
        $this->_artId = $artId;
    }

    public function attach()
    {
        $album = VkAlbumModel::find($this->_albumId);
        if (!$album) {
            throw new \Exception('Не найден альбом');
        }
        $getPicture = new GetPicture($this->_artId);
        $picture = $getPicture->withHiddenVkTag()->get();
        $photoId = $this->_postPhotoInAlbum($album, $picture);
        $vkAlbumPictureModel = new VkAlbumPictureModel();
        $vkAlbumPictureModel->vk_album_id = $album->id;
        $vkAlbumPictureModel->out_vk_image_id = $photoId;
        $vkAlbumPictureModel->picture_id = $picture->id;
        $album->pictures()->save($vkAlbumPictureModel);
    }

    private function _postPhotoInAlbum($album, $picture)
    {
        $uploadUrl = $this->_getUploadServer($album->album_id);
        $path = base_path('public/arts/') . $picture->path;
        $server = $this->_uploadPhoto($uploadUrl, $path);
        $photoId = $this->_savePhoto($server, $album->album_id);
        $url = 'https://drawitbook.ru';
        $hashTags = $this->_formatTagsForVk($picture->tags->pluck('name')->toArray());
        sleep(1);
        $this->_editPhoto($photoId, ['caption' => $hashTags . "\n\n" . ' Ещё больше рисунков на ' . $url]);
        return $photoId;
    }

    private function _formatTagsForVk(array $tags)
    {
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('/\s+/', '', $tag);
            $tags[$key] = str_ireplace('-', '', $tags[$key]);
        }
        $hashTags = '#рисунки #рисункипоклеточкам';
        if ($tags) {
            $hashTags .= ' #' . implode(' #', $tags);
        }
        $hashTags .= ' #drawitbook';
        return $hashTags;
    }

    private function _postVk()
    {
        /*   $pictures = PictureModel::with(['tags' => function ($q) {
               $q->where('spr_tags.hidden_vk', '=', 0);
           }])->whereIn('id', $artIds)->get();

           $uploadUrl = $this->_getUploadServer();

           $url = 'tag[]=домашние животные';
           $url = 'https://drawitbook.ru/search?' . urlencode($url);
           $url = str_ireplace('%3D', '=', $url);

           foreach ($pictures as $picture) {
               $path = base_path('public/arts/') . $picture->path;
               $tags = $picture->tags->pluck('name')->toArray();
               foreach ($tags as $key => $tag) {
                   $tags[$key] = preg_replace('/\s+/', '', $tag);
                   $tags[$key] = str_ireplace('-', '', $tags[$key]);
               }
               $hashTags = '#рисунки #рисункипоклеточкам';
               if ($tags) {
                   $hashTags .= ' #' . implode(' #', $tags);
               }
               $hashTags .= ' #drawitbook';

               /*  if (empty($payload[$picture->id])) {
                     $payload[$picture->id] = [];
                 }*/
//            $payload[$picture->id]['caption'] = $hashTags . '%0A' . 'Ещё больше рисунков на ' . $url;

        /*    $client = new \GuzzleHttp\Client();
            $res = $client->post($uploadUrl, [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'contents' => fopen($path, 'r')
                    ],
                ],
            ]);
            $server = json_decode($res->getBody()->getContents(), true);*/
//            $payload[$picture->id] = ['id' => $server];

//            $photoId = $this->_savePhoto($server);
        /*   $photoId = 456239067;

           $this->_editPhoto($photoId, ['caption' => $hashTags . "\n\n" . ' Ещё больше рисунков на ' . $url]);

       }*/
    }

}
