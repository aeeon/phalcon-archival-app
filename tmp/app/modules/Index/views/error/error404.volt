{% if registry.cms['DEBUG_MODE'] %}
<p>--------------------------<br>Debug mode error details:</p>
{% if e is defined %}
<p>{{ e.getMessage() }}</p>
<p>{{ e.getFile() }}::{{ e.getLine() }}</p>
<pre>{{ e.getTraceAsString() }}</pre>
{% endif %}
{% if message %}
{{ message }}
{% endif %}

{% else %}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Błąd 404</title>

        <link href="{{ url.path() }}assets/css/custom.css" rel="stylesheet">

        <script src="{{ url.path() }}vendor/js/jquery-1.11.3.min.js"></script>
        <link href="{{ url.path() }}assets/bower_components/Swiper/dist/css/swiper.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->



    </head>
    <body>

        <div id="wrapper">
<main id="site-main" class="container-fluid">
    <header id="main-header">

{{ partial('../../../views/partials/main/header') }}
        {{ partial('../../../views/partials/main/menu') }}
    </header>



    <div class="container" id="main-content">
        <h3>Przepraszamy. Strona nie została znaleziona.<h3>
                <h4>Wystąpił błąd 404</h4>
                <p></p>
                <p>Powrót na <a href="{{ url.path()}}" title="Powrót">stronę główną</a></p>
    </div>

</main>

<footer  id="main-footer">
    {{ partial('../../../views/partials/main/footer') }}
</footer>
        </div>
        <script src="{{ url.path() }}assets/bower_components/Swiper/dist/js/swiper.jquery.min.js"></script>  
        <script src="{{ url.path() }}assets/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>     
        <script src="{{ url.path() }}assets/js/main-menu.js"></script>   
        <script src="{{ url.path() }}assets/js/custom.js"></script>  
    </body>
</html>
{% endif %}

