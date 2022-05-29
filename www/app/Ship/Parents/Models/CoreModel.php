<?php

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Model;

class CoreModel extends Model
{
    public $timestamps = false;
    protected $fillable = [];

    public function scopeExcludeSelect($query, $excludeColumns = [])
    {
        if (isset($this->columns)) {
            return $query->select(array_diff($this->columns, $excludeColumns));
        }
    }

    public static function mapToArray(array $objectsArray): array
    {
        $result = [];
        foreach ($objectsArray as $item) {
            $result[] = (array) $item;
        }
        return $result;
    }

    public function scopeFirstArray($query)
    {
        return collect($query->first())->toArray();
    }
}