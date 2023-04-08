<?php

namespace App\Containers\SocialMediaPosting\Data\Factories;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\SocialMediaPosting\Enums\SocialMediaPostingHistoryColumnsEnum;
use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaPostingHistoryModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = SocialMediaPostingHistoryModel::class;

    /**
     * Define the model's default state.
     *
     * @return array{picture_id: Factory<PictureModel>}
     */
    public function definition(): array
    {
        return [
            SocialMediaPostingHistoryColumnsEnum::PICTURE_ID => PictureModel::factory(),
        ];
    }
}

