<?php

namespace App\Entities\User;

use App\Models\CoreModel;

class UserClaimModel extends CoreModel
{
    protected $table = 'user_claim';

    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
