<?php
namespace Database\Seeders;
use App\Models\Categories;
use App\Models\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
class PermissionsSeeder extends Seeder {
    public function run() {
        Schema::disableForeignKeyConstraints();
        Permissions::truncate();
        Schema::enableForeignKeyConstraints();

        $items = $this->findActions();
        foreach ($items as $item) {
            Permissions::create($item);
        }
        $categories = Categories::get();
        foreach ($categories as $category) {
            Permissions::create([
                'name' => 'دسته بندی: ' . $category->title,
                'slug' => 'nc_' . $category->id
            ]);
        }
    }
    private function findActions() {
        $items       = [];
        $path        = realpath(__DIR__ . '/../../app/Http/Controllers');
        $controllers = array_diff(scandir($path), ['..', '.']);
        foreach ($controllers as $controller) {
            $content = file_get_contents(realpath($path . '/' . $controller));
            $titles  = [];
            $actions = [];
            preg_match_all("|title='(.*)'|U", $content, $titles);
            preg_match_all("|action='(.*)'|U", $content, $actions);
            if (!$titles[1] || !$actions[1] || count($titles[1]) !== count($actions[1])) {
                continue;
            }
            $controller_name = str_replace('.php', '', $controller);
            foreach ($titles[1] as $index => $title) {
                $items[] = ['name' => $title, 'slug' => $controller_name . '@' . $actions[1][$index]];
            }
        }
        return $items;
    }
}