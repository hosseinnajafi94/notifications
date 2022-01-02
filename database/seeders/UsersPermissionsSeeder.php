<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permissions;
use App\Models\UsersPermissions;
class UsersPermissionsSeeder extends Seeder {
    public function run() {
        $permissions = Permissions::get();
        foreach ($permissions as $permission) {
            UsersPermissions::create([
                'user_id'       => 1,
                'permission_id' => $permission->id,
            ]);
        }
    }
}