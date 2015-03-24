<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 27/01/2015
 * Time: 17:49
 */

/*
|--------------------------------------------------------------------------
| Tags personnalisés pour blade
|--------------------------------------------------------------------------
|
| Juste des tags personnalisés pour Blade. Un peu de bidouille pour étendre
| des fonctionnalités.
|
*/


/**
 * Pour pouvoir utiliser du php dans Blade sans ouvrir de balise php (code plus uniforme)
 * Syntaxe: @php($var ou quelque chose en php), typée syntaxe Blade
 * Exemple: @php($truc = ['bidule', 'machin']) => renvoie <?php $truc = ['bidule', 'machin'] ?>
 * @param $variable
 * @return mixed
 */
Blade::extend(function($variable) {
    return preg_replace('/\@php\((.+)\)/', '<?php ${1} ?>', $variable);
});