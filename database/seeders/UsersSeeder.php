<?php
namespace Database\Seeders;
use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\UsersPermissions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
class UsersSeeder extends Seeder {
    public function run() {
        
        Schema::disableForeignKeyConstraints();
        UsersPermissions::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Factory::create();

        User::create([
            'fname'    => 'حسین',
            'lname'    => 'نجفی',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'email'    => 'me@hosseinnajafi.ir',
        ]);

        $password = Hash::make('2');
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'fname'    => $faker->firstName,
                'lname'    => $faker->lastName,
                'username' => $faker->userName,
                'password' => $password,
                'email'    => $faker->email,
            ]);
        }
    }
}