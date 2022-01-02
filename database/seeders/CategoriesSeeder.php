<?php
namespace Database\Seeders;
use App\Models\Categories;
use App\Models\Notifications;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
class CategoriesSeeder extends Seeder {
    public function run() {
        Schema::disableForeignKeyConstraints();
        Notifications::truncate();
        Categories::truncate();
        Schema::enableForeignKeyConstraints();
        Categories::create(['title' => 'اطلاعیه']);
        Categories::create(['title' => 'اعلامیه']);
        Categories::create(['title' => 'حذف شده']);
        Categories::findOrFail(3)->delete();
    }
}