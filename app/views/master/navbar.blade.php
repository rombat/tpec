<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Déployer navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img alt="Nesti" src="{{ asset('/images/logo.png') }}" height="50"></a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Catégories <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('categories.index', 'Voir toutes les catégories') }}</li>
                        <li>{{ link_to_route('categories.create', 'Créer une nouvelle catégorie') }}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recettes<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('recettes.index', 'Voir toutes les recettes') }}</li>
                        <li>{{ link_to_route('recettes.create', 'Créer une nouvelle recette') }}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ingrédients<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('ingredients.index', 'Voir tous les ingrédients') }}</li>
                        <li>{{ link_to_route('ingredients.create', 'Créer un nouvel ingrédient') }}</li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Conditionnements<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>{{ link_to_route('conditionnements.index', 'Voir tous les conditionnements') }}</li>
                        <li>{{ link_to_route('conditionnements.create', 'Créer un nouveau conditionnement') }}</li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>