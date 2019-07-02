<?php

namespace App\Entities\User;

use Illuminate\Database\Eloquent\Model;

class UserActivityModel extends Model
{
    protected $table = 'user_activity';
    public $timestamps = true;
    protected $fillable = [
        'activity',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}