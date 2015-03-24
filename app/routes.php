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

Route::get('/', function()
{
	return View::make('hello');
});


Route::resource('recettes', 'RecettesController');

Route::resource('ingredients', 'IngredientsController');

Route::resource('categories', 'CategoriesController');

Route::resource('commentaires', 'CommentairesController');

Route::resource('users', 'UsersController');

Route::resource('adresses', 'AdressesController');

Route::resource('commandes', 'CommandesController');

Route::resource('details_commandes', 'Details_commandesController');

Route::resource('images', 'ImagesController');