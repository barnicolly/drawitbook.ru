<?php

declare(strict_types=1);

namespace App\Containers\User\Models;

use App\Containers\User\Data\Factories\UserModelFactory;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Containers\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 *
 * @method static UserModelFactory factory
 */
final class User extends UserModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory(): UserModelFactory
    {
        return UserModelFactory::new();
    }

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole(array|string $roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } elseif ($this->hasRole($roles)) {
            return true;
        }
        return false;
    }

    public function hasRole(string $role): bool
    {
        return (bool) $this->roles()->where('name', $role)->first();
    }
}
