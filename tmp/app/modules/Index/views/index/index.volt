<div id="main-content">
      {{ helper.staticWidget('zobacz-jakie-to-proste') }}

    <div class="content-container col-lg-7 col-md-6 noright">
        <div id="newest-post-box" class="{{ format }}">
            <div class="col-lg-12 noleft"><h2><span class="bold">Najnowsze</span> artykuły</h2></div>

            {% if paginate.total_items > 0 %}
            {% for item in paginate.items %}
            {{ helper.modulePartial('../../Publication/views/index/format/' ~ format, ['item':item]) }}
            {% if loop.index % 2 == 0  %}
            <div class="clear"></div>
            {% endif %}
            {% endfor %}
            {% else %}
            <p>{{ helper.translate('Brak istniejących wpisów') }}</p>
            {% endif %}

        </div>
        <div class="col-lg-12 noleft pagination-box">

            {% if paginate.total_pages > 1 %}
            {{ partial('main/pagination', ['paginate':paginate] ) }}
            {% endif %}                           
        </div>
    </div>
    <aside class="sidebar-container col-lg-5 col-md-6 noleft">
        {{ helper.widget('Publication').popularArticles() }}
        {{ helper.staticWidget('ads-box-1') }}
        {{ helper.staticWidget('newsletter-box') }}
    </aside>
</div>
<div id="after-content" class="col-lg-12 noleft">
    {# helper.staticWidget('our-team-box') #}

</div>
