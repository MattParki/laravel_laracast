<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Main Landing page for all the blog posts
Route::get('/', function () {
    return view('posts');
});

Route::get('posts/{post}', function($slug) {
    // Create the path 
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    // Check to see if the file exists, if true -> fetch the contents of the file then pass it to the view
    if (! file_exists($path)) {
        return redirect('/');
    }

    //caching in order to save the contents of the page on the hosts computer in order not to run too many responses
    $post = cache()->remember("posts.{$slug}", now()->addMinutes(20), function () use ($path) {
        var_dump('file_get_contents');
        return file_get_contents($path);

    });

    //once file exists is true it will then return the post.blade.php view
    return view('post', ['post' => $post]);
    
    //will display only if the text contraints in the url match the ones set below
})->where('post', '[A-z_/-]+');