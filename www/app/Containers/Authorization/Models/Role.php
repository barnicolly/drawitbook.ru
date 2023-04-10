<?php

namespace App\Containers\Authorization\Models;

use App\Containers\Authorization\Data\Factories\RoleModelFactory;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @method static RoleModelFactory factory
 */
class Role extends Model
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }

    protected static function newFactory(): RoleModelFactory
    {
        return RoleModelFactory::new();
    }
}
