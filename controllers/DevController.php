<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use File;

class DevController extends Controller {
    public function index() {
        // routes
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'methods' => $route->methods(),
                'middleware' => $route->gatherMiddleware(),
            ];
        })->filter(fn($r) => $r['name'] // only named routes
            && in_array('GET', $r['methods']) // only get methods
            && in_array('web', $r['middleware'])); // only web.php routes 

        // icons
        $icons = File::allFiles(resource_path('views\components\icons'));

        return view('dev', compact('routes', 'icons'));
    }
}
