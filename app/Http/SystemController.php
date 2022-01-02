<?php
namespace App\Http;
use App\Models\Permissions;
use App\Models\UsersPermissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Support\Facades\Schema;
class SystemController extends Controller {
    public function clearcache() {
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
    }
    public function redraw() {
        //Schema::disableForeignKeyConstraints();
        //UsersPermissions::truncate();
        //Permissions::truncate();
        //Schema::enableForeignKeyConstraints();

        $items       = $this->findActions();
        $permissions = $this->findPermissions();
        foreach ($items as $item) {
            $find = false;
            foreach ($permissions as $index => $permission) {
                if ($item['slug'] === $permission->slug) {
                    $find = true;
                    $permission->update($item);
                    unset($permissions[$index]);
                    break;
                }
            }
            if (!$find) {
                $record = Permissions::create($item);
                UsersPermissions::create(['user_id' => 1, 'permission_id' => $record->id]);
            }
        }
        foreach ($permissions as $permission) {
            $permission->delete();
        }
    }
    private function findPermissions() {
        return Permissions::get();
    }
    private function findActions() {
        $items       = [];
        $path        = realpath(__DIR__ . '/Controllers');
        $controllers = array_diff(scandir($path), ['..', '.']);
        foreach ($controllers as $controller) {
            //if ($controller === 'AuthController.php') {
            //    continue;
            //}
            $content = file_get_contents(realpath($path . '/' . $controller));
            $titles  = [];
            $actions = [];
            preg_match_all("|title='(.*)'|U", $content, $titles);
            preg_match_all("|action='(.*)'|U", $content, $actions);
            if (!$titles[1] || !$actions[1] || count($titles[1]) !== count($actions[1])) {
                continue;
            }
            //$namespace = [];
            //preg_match_all("|namespace (.*);|U", $content, $namespace);
            //$controller_name = str_replace('\\', '/', $namespace[1][0]) . '/' . str_replace('.php', '', $controller);
            $controller_name = str_replace('.php', '', $controller);
            foreach ($titles[1] as $index => $title) {
                $items[] = ['name' => $title, 'slug' => $controller_name . '@' . $actions[1][$index]];
            }
        }
        return $items;
        //$routes      = Route::getRoutes()->getRoutes();
        //$controllers = [];
        //$i           = 0;
        //foreach ($routes as $route) {
        //    $action = $route->getAction('controller');
        //    if ($action) {
        //        $action = str_replace('\\', '/', $action);
        //        if (strpos($action, 'App/Http/Controllers') !== false) {
        //            $controllers[$i] = $action;
        //            $i++;
        //        }
        //    }
        //}
        //var_dump($controllers);
    }
}