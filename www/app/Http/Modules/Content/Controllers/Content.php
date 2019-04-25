<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Http\Modules\Database\Models\Common\Raw\PictureViewModel as RawPictureViewModel;
use App\Http\Modules\Database\Models\Common\Picture\PictureViewsModel as PictureViewModel;
use App\Http\Modules\Database\Models\Common\User\UserActivityModel;
use App\Libraries\Template;
use MetaTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Validation\Rule;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $pictures = PictureModel::take(40)->with(['tags'])->get();

        $viewData['pictures'] = $pictures;
        return $template->loadView('Content::index', $viewData);
    }

    public function art(int $id)
    {
        $picture = PictureModel::with(['tags'])->findOrFail($id);
        list($shown, $hidden) = $this->_getTagIds($picture);
        $relativePictures = [];
        if ($shown || $hidden) {
            $pictureIds = $this->_searchRelatedPicturesIds($shown, $hidden);
            if ($pictureIds) {
                $relativePictures = PictureModel::with(['tags'])->whereIn('id', $pictureIds)->get();
            }
        }
        $viewData = ['picture' => $picture, 'relativePictures' => $relativePictures];
        $template = new Template();
        MetaTag::set('title', 'Art #' . $id . ' Drawitbook.ru');
        MetaTag::set('description', 'This is my home. Enjoy!');
        MetaTag::set('image', asset('arts/' . $picture->path));

        $this->_insertUserView($picture->id);
        return $template->loadView('Content::art.index', $viewData);
    }

    public function like($id, Request $request)
    {
        $validator = Validator::make(['id' => $id, 'off' => $request->input('off')], [
            'id' => 'required|integer',
            'off' => [
                'required',
                Rule::in(['true', 'false']),
            ]
        ]);
        $result['success'] = false;
        if ($validator->fails()) {
            return response($result);
        }
        $picture = PictureModel::find($id);
        if ($picture === null) {
            return response($result);
        }
        $this->_createOrModifyUserActivity($picture, true, $request->input('off') === 'true');


        $result['success'] = true;
        return response($result);
    }

    private function _createOrModifyUserActivity(PictureModel $picture, bool $like, bool $off)
    {
        $activity = UserActivityModel::whereIn('activity', [1, 2])->where('picture_id', '=', $picture->id)->first();
        if ($activity === null) {
            if (!$off) {
                $ip = request()->ip();
                $ip = DB::connection()->getPdo()->quote($ip);
                $activity = UserActivityModel::create();
                $activity->picture_id = $picture->id;
                $activity->ip = DB::raw("inet_aton($ip)");
                $activity->activity = $like ? 1 : 2;
                $activity->user_id = auth()->id();
            }
        } else {
            if (!$off) {
                $activity->activity = $like ? 1 : 2;
                $activity->is_del = 0;
            } else {
                $activity->is_del = 1;
            }
        }
        if ($activity !== null) {
            $activity->save();
        }
        return true;
    }


    public function dislike($id, Request $request)
    {
        $validator = Validator::make(['id' => $id, 'off' => $request->input('off')], [
            'id' => 'required|integer',
            'off' => [
                'required',
                Rule::in(['true', 'false']),
            ]
        ]);
        $result['success'] = false;
        if ($validator->fails()) {
            return response($result);
        }
        $picture = PictureModel::find($id);
        if ($picture === null) {
            return response($result);
        }
        $this->_createOrModifyUserActivity($picture, false, $request->input('off') === 'true');
        $result['success'] = true;
        return response($result);
    }

    private function _insertUserView(int $pictureId)
    {
        $ip = request()->ip();
        $ip = DB::connection()->getPdo()->quote($ip);

        if (!in_array($ip, ['127.0.0.1'])) {
            $rawView = new RawPictureViewModel();
            $rawView->picture_id = $pictureId;
            $rawView->user_id = auth()->id();
            $rawView->ip = DB::raw("inet_aton($ip)");
            $rawView->save();
        }
    }

    private function _getTagIds(PictureModel $picture): array
    {
        $hidden = [];
        $shown = [];
        foreach ($picture->tags as $tag) {
            if ($tag->hidden === 1) {
                $hidden[] = $tag->id;
            } else {
                $shown[] = $tag->id;
            }
        }
        return [$shown, $hidden];
    }

    private function _searchRelatedPicturesIds(array $shown, array $hidden)
    {
        $sphinx = new SphinxSearch();
        $sphinx->search('', 'drawItBookSearchByTag')
            ->limit(20)
            ->setFieldWeights(
                array(
                    'hidden_tag' => 3,
                    'tag' => 8,
                )
            )
            ->setSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, '@relevance DESC')
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED);
        if ($hidden) {
            $sphinx->filter('hidden_tag', $hidden);
        }
        if ($shown) {
            $sphinx->filter('tag', $shown);
        }
        $results = $sphinx->query();
        if (!empty($results['matches'])) {
            $pictureIds = array_keys($results['matches']);
//            if (count($pictureIds) < 20 && $hidden) {
//                $sphinx = new SphinxSearch();
//                $sphinx->search('', 'drawItBookSearchByTag')
//                    ->limit(20)
//                    ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED2)
//                    ->filter('hidden_tag', $hidden);
//                $resultsHidden = $sphinx->query();
//                if (!empty($resultsHidden['matches'])) {
//                    $pictureIds = array_merge($pictureIds, array_keys($results['matches']));
//                    $pictureIds = array_unique($pictureIds);
//                    $pictureIds = array_slice($pictureIds, 0, 20);
//                }
//            }

            return $pictureIds;
        }
        return [];
    }

}
