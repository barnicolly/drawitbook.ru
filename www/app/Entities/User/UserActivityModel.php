<?php

namespace App\Entities\User;

use App\Models\CoreModel;

class UserActivityModel extends CoreModel
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
