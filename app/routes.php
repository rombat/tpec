<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
 * Routes model binding
 */

Route::bind('recettes', function($url) {
   return Recette::where('id', '=', $url)->firstOrFail();
});

Route::bind('ingredients', function($url) {
    return Ingredient::where('id', '=', $url)->firstOrFail();
});

Route::bind('categories', function($url) {
    return Categorie::where('id', '=', $url)->firstOrFail();
});

Route::bind('conditionnements', function($url) {
    return Conditionnement::where('id', '=', $url)->firstOrFail();
});

/*
 * Routes pattern
 */
Route::pattern('recettes', '[0-9a-z-]+');
Route::pattern('ingredients', '[0-9a-z-]+');
Route::pattern('categories', '[0-9a-z-]+');
Route::pattern('conditionnements', '[0-9a-z-]+');


Route::get('/', array('as' => 'home', function()
{
	return View::make('home.show');
}));


Route::resource('recettes', 'RecettesController');

Route::resource('ingredients', 'IngredientsController');

Route::resource('categories', 'CategoriesController');

Route::resource('conditionnements', 'ConditionnementsController');



/**
 * ---------------------------------------------
 * Routes non prévues: 404
 * Note: les erreurs peuvent être gérées plus
 * finement dans start/global.php dans la partie
 * Application Error Handler
 * ---------------------------------------------
 */

App::missing(function()
{
    Log::error('Erreur 404 sur: ' .Request::url());
    return Response::view('errors.404', array(), 404);
//	return Redirect::route('home');
});