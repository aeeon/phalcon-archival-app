<main id="site-main" class="container-fluid">
    <header id="main-header">

        {{ partial('main/header') }}
        {{ partial('main/menu') }}
    </header>



    {{ content() }}

    {% if seo_text is defined and seo_text_inner is not defined %}
    <!-- <div class="seo-text">
         {{ seo_text }}
     </div>-->
    {% endif %}
</main>

<footer  id="main-footer">
    {{ partial('main/footer') }}
</footer>

{% if registry.cms['PROFILER'] %}
{{ helper.dbProfiler() }}
{% endif %}

{{ helper.javascript('body') }}