<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{ helper.title().get()|escape }}</title>

        {{ helper.meta().get('description') }}
        {{ helper.meta().get('keywords') }}
        {{ helper.meta().get('seo-manager') }}

        <script src="{{ url.path() }}vendor/js/jquery-1.11.3.min.js"></script>

        <link href="{{ url.path() }}assets/css/custom.css" rel="stylesheet">
        <link href="{{ url.path() }}assets/bower_components/Swiper/dist/css/swiper.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!--js-->
        {# assets.outputJs('js') #}
        <!--/js-->

        {{ helper.javascript('head') }}

    </head>
    <body{% if view.bodyClass %} class="{{ view.bodyClass }}"{% endif %}>

        <div id="wrapper">
            {{ content() }}
        </div>

        <script src="{{ url.path() }}assets/bower_components/Swiper/dist/js/swiper.jquery.min.js"></script>  
        <script src="{{ url.path() }}assets/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>     
        <script src="{{ url.path() }}assets/js/main-menu.js"></script>   
        <script src="{{ url.path() }}assets/js/custom.js"></script>  
    </body>
</html>