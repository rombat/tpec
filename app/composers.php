<?php
/**
 * Created by PhpStorm.
 * User: Romain
 * Date: 07/01/2015
 * Time: 15:31
 */

/*
|--------------------------------------------------------------------------
| View composers
|--------------------------------------------------------------------------
|
| Les view composer permettent de lier à une vue des fonctions ou des appels
| d'éléments qui seront utilisés/insérés à chaque fois que la vue est utilisée
|
*/


/* Ici, View Composer pour préparer des containers d'assets (js, css...) pour que les vues soient plus claires à lire */
View::composer(array('template','errors.maintenance'), function() {

    // Container pour les scripts JS chargés via CDN
    Asset::add(array(
        'https://code.jquery.com/jquery-1.11.2.min.js',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js',
    ), 'CdnJs');

    // Container pour les scripts JS d'Artificial Reason (sauf ceux en async ou defer)
    Asset::add(array(
        '/packages/artificial-reason/js/jquery.cookie.js',
        '/packages/artificial-reason/js/slidebars.js',
        '/packages/artificial-reason/js/jquery.bxslider.min.js',
        '/packages/artificial-reason/js/holder.js'
    ), 'ArtificialJs');

    // Container pour les CSS chargés via CDN
    Asset::add(array(
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'
    ), 'CdnCss');

    // Container pour les CSS d'Artificial Reason (le template utilisé)
    Asset::add(array(
        '/packages/artificial-reason/css/preload.css',
        '/packages/artificial-reason/css/yamm.css',
        '/packages/artificial-reason/css/bootstrap-switch.min.css',
        '/packages/artificial-reason/css/animate.min.css',
        '/packages/artificial-reason/css/slidebars.css',
        '/packages/artificial-reason/css/lightbox.css',
        '/packages/artificial-reason/css/jquery.bxslider.css',
        '/packages/artificial-reason/css/width-full.css',
        '/packages/artificial-reason/css/buttons.css'
    ), 'ArtificialCss');


    // Container pour les .css.less créés chez MG
    Asset::add(array(
        'css/maingauche.less',
        'css/styles_armg.css'));
}
);

/* View composer pour générer le menu sans passer par un controller. On choppe toutes les categories actives, ainsi que les marques */
View::composer('master.navbar', function($vue) {

    $categories = Categorie::where('actif', '=', '1')->get();
    $marques = Marque::all();

    $vue->with('categories', $categories)
        ->with('marques', $marques);
});

/* View composer pour générer le menu off-canvas sans passer par un controller. On choppe toutes les sections actives */
View::composer(array('master.offcanvas-navbar', 'master.footer'), function($vue) {
    $sections_meres = Section::where('actif', '=', '1')->where('parent_id', '=', '0')->orderBy('ordre')->get();
    $vue->with('sections_meres', $sections_meres);
});

/* View composer pour choper les billets du blog dans le RSS */
View::composer('master.footer', function($vue) {
    $feed = new SimplePie();
    $feed->set_feed_url("http://blog.main-gauche.com/feed/");
    $feed->enable_cache(true);
    $feed->set_cache_location(storage_path().'/cache');
    $feed->set_cache_duration(60*60*12);
    $feed->set_output_encoding('utf-8');
    $feed->init();
    $vue->with('feed', $feed);
});


/* View composer pour les carousels */
View::composer(array('statique.carousel', 'pages.home.carousel'), function($vue) {
    $carousels = CarouselHome::where('actif', '=', '1')->get();
    $vue->with('carousels', $carousels);
});

/* View composer pour l'affichage de la box "Nos clients"
    On prend 8 commentaires clients aléatoirement dans la base */
View::composer('pages.home.ourclients', function($vue) {
    $clients = CommentairesClient::orderByRaw('RAND()')->take(8)->get();
    $vue->with('clients', $clients);
});

