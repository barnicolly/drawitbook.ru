<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'User')
            ->first();
        $role_admin = Role::where('name', 'Admin')
            ->first();
        $user = new User();
        $user->name = 'Тестовый пользователь';
        $user->email = 'visitor@example.com';
        $user->password = bcrypt('P1i87tnr__262');
        $user->save();
        $user->roles()
            ->attach($role_user);
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'mik009@narod.ru';
        $admin->password = bcrypt('P1i87tnr__262');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}