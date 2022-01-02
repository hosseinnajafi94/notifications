<?php
namespace Database\Seeders;
use Faker\Factory;
use App\Models\Notifications;
use Illuminate\Database\Seeder;
class NotificationsSeeder extends Seeder {
    public function run() {
        Notifications::truncate();
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Notifications::create([
                'category_id' => 1,
                'title'       => $faker->sentence,
                'description' => $faker->paragraph,
                'file'        => null,
                'exp_time'    => date('Y-m-d H:i:s', strtotime('+10 days')),
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Notifications::create([
                'category_id' => 2,
                'title'       => $faker->sentence,
                'description' => $faker->paragraph,
                'file'        => null,
                'exp_time'    => date('Y-m-d H:i:s', strtotime('+10 days')),
            ]);
        }
    }
}