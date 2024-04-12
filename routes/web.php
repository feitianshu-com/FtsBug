<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\PostController;
use App\Http\Controllers\Home\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/welcome', function () {
//     return view('welcome');
// });
$languageList = 'en|zh_CN';

Route::get('/to/zh', function () {
    session(['Language' => 'zh_CN']);
    config(['app.locale' => 'zh_CN']);
    return redirect("zh_CN");
})->name('zh_CN');

Route::get('/to/en', function () {
    session(['Language' => 'en']);
    config(['app.locale' => 'en']);
    return redirect("en");
})->name('en');

Route::get('/', function (Request $request) {
    $locale = 'en';
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); //只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。
    if (preg_match("/zh-c/i", $lang))
        $locale = 'zh_CN';
    else if (preg_match("/zh/i", $lang))
        $locale = 'zh_CN';
    
    return redirect($locale);
});

Route::prefix('{lang}')->where(['lang'=>$languageList])->middleware('\App\Http\Middleware\SetLocale')->get('/', function () {
    return view('welcome');
});

$optionalLanguageRoutes = function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified','\App\Http\Middleware\SetLocale'])->name('dashboard');

    Route::middleware('auth', 'verified','\App\Http\Middleware\SetLocale')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        Route::get('/posts/createtodo/{project_id}', [PostController::class, 'createtodo'])->name('posts.createtodo');
        Route::get('/posts/createbug/{project_id}', [PostController::class, 'createbug'])->name('posts.createbug');
        Route::get('/posts/todo/{project_id}', [PostController::class, 'todo'])->name('posts.todo');
        Route::get('/posts/bug/{project_id}', [PostController::class, 'bug'])->name('posts.bug');
        Route::resource('posts', 'App\\Http\\Controllers\\Home\PostController');
        Route::resource('comments', 'App\\Http\\Controllers\\Home\CommentController');
        Route::post('/projects/adduser', [ProjectController::class, 'adduser'])->name('projects.adduser');
        Route::delete('/projects/deluser/{id}', [ProjectController::class, 'deluser'])->name('projects.deluser');
        Route::post('/projects/changeuser/{id}/{role}', [ProjectController::class, 'changeuser'])->name('projects.changeuser');
        Route::resource('projects', 'App\\Http\\Controllers\\Home\ProjectController');
    });
};

// Add routes with lang-prefix
// if ($languageList) {
//     Route::group(
//         ['prefix' => '/{lang}/', 'where' => ['lang' => $languageList], 'as'=>'lang.'],
//         $optionalLanguageRoutes
//     );
// }
$optionalLanguageRoutes();

require __DIR__.'/auth.php';
