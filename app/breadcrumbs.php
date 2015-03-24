<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 21/01/2015
 * Time: 16:55
 */

/*
|--------------------------------------------------------------------------
| Breadcrumbs (Fil d'Ariane)
|--------------------------------------------------------------------------
|
| On définit ici comment est organisé le fil d'ariane
| Par soucis pratique, les breadcrumbs auront les mêmes noms que les routes
|
*/

Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Accueil', route('home'));
});

Breadcrumbs::register('page_categorie', function($breadcrumbs, $categorie) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($categorie->nom, route('page_categorie', $categorie->url));
});

Breadcrumbs::register('fiche_produit', function($breadcrumbs, $produit) {
    $breadcrumbs->parent('page_categorie', $produit->categories->first());
    $breadcrumbs->push($produit->nom, route('fiche_produit'));
});

Breadcrumbs::register('page_marque', function($breadcrumbs, $marque) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($marque->nom, route('page_marque', $marque->url));
});

Breadcrumbs::register('section', function($breadcrumbs, $section) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($section->nom, route('section', $section->url));
});

Breadcrumbs::register('tags_index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Mots clés', route('tags_index'));
});

Breadcrumbs::register('tags', function($breadcrumbs, $tag) {
    $breadcrumbs->parent('tags_index');
    $breadcrumbs->push($tag->tag, route('tags', $tag->tag_url));
});

Breadcrumbs::register('recherche', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Recherche', route('recherche'));
});

