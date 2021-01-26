<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entities\Picture{
/**
 * App\Entities\Picture\PictureModel
 *
 * @property int $id
 * @property string|null $path
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_del
 * @property int|null $in_common
 * @property int|null $in_vk_posting
 * @property int|null $width
 * @property int|null $height
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Spr\SprTagsModel[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereInCommon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereInVkPosting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureModel whereWidth($value)
 */
	class PictureModel extends \Eloquent {}
}

namespace App\Entities\Picture{
/**
 * App\Entities\Picture\PictureTagsModel
 *
 * @property int $id
 * @property int|null $picture_id
 * @property int|null $tag_id
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PictureTagsModel whereTagId($value)
 */
	class PictureTagsModel extends \Eloquent {}
}

namespace App\Entities\Spr{
/**
 * App\Entities\Spr\SprTagsModel
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $hidden
 * @property int|null $hidden_vk
 * @property string|null $seo
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel whereHiddenVk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SprTagsModel whereSeo($value)
 */
	class SprTagsModel extends \Eloquent {}
}

namespace App\Entities\User{
/**
 * App\Entities\User\UserActivityModel
 *
 * @property int $id
 * @property int|null $ip
 * @property int|null $user_id
 * @property int|null $picture_id
 * @property int|null $activity 1 - like
 * 2 - unlike
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $status
 * @property int|null $is_del
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereIsDel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivityModel whereUserId($value)
 */
	class UserActivityModel extends \Eloquent {}
}

namespace App\Entities\User{
/**
 * App\Entities\User\UserClaimModel
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ip
 * @property int $picture_id
 * @property int|null $reason_id
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel whereReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserClaimModel whereUserId($value)
 */
	class UserClaimModel extends \Eloquent {}
}

namespace App\Entities\Vk{
/**
 * App\Entities\Vk\HistoryPostingModel
 *
 * @property int $id
 * @property int $picture_id
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HistoryPostingModel wherePictureId($value)
 */
	class HistoryPostingModel extends \Eloquent {}
}

namespace App\Entities\Vk{
/**
 * App\Entities\Vk\VkAlbumModel
 *
 * @property int $id
 * @property int $album_id
 * @property string $description
 * @property string|null $share
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Vk\VkAlbumPictureModel[] $pictures
 * @property-read int|null $pictures_count
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumModel whereShare($value)
 */
	class VkAlbumModel extends \Eloquent {}
}

namespace App\Entities\Vk{
/**
 * App\Entities\Vk\VkAlbumPictureModel
 *
 * @property int $id
 * @property int $vk_album_id
 * @property int $picture_id
 * @property int $out_vk_image_id
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel whereOutVkImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkAlbumPictureModel whereVkAlbumId($value)
 */
	class VkAlbumPictureModel extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

