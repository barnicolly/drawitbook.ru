<?php

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Model;

class CoreModel extends Model
{
    public $timestamps = false;
    protected $fillable = [];

    public static function mapToArray(array $objectsArray): array
    {
        $result = [];
        foreach ($objectsArray as $item) {
            $result[] = (array) $item;
        }
        return $result;
    }
}
