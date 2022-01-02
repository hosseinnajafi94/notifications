<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call(CategoriesSeeder::class);
        $this->call(NotificationsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UsersPermissionsSeeder::class);
    }
}