<?php

namespace App\Http\Modules\Database\Models\Common\User;

use Illuminate\Database\Eloquent\Model;

class UserClaimModel extends Model
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
