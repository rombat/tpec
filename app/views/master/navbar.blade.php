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
            <a class="navbar-brand" href="{{ route('home') }}"><img alt="Nesti" src="{{ asset('/images/logo.png') }}"></a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>{{ link_to_route('categories.index', 'Catégories') }}</li>
                <li>{{ link_to_route('recettes.index', 'Recettes') }}</li>
                <li>{{ link_to_route('ingredients.index', 'Ingrédients') }}</li>
                <li>{{ link_to_route('conditionnements.index', 'Conditionnements') }}</li>

            </ul>

        </div>
    </div>
</nav>