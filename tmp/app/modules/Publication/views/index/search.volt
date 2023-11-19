<div id="main-content">

    <div class="content-container col-lg-7 col-md-6 noright">
        <div id="newest-post-box" class="{{ format }}">
            <div class="col-lg-12 noleft">
                <div class="title-bar">
                    <!--<h1>{{ title }}</h1>-->
                    <h1><strong>WYNIKI</strong> Wyszukiwania</h1>
                </div>

            </div>
         {% if search  %}
            <p>Wyszukiwana fraza: {{ search }}</p>

            {% if paginate.total_items > 0 %}
            {% for item in paginate.items %}

            {{ helper.modulePartial('index/format/grid', ['item':item]) }}
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
        {% else %}
        <p>{{ helper.translate('Wpisana fraza jest zbyt krótka. Prosimy spróbować ponownie wpisując minimum trzy znaki.') }}</p>
    </div>
    {% endif %} 
</div>
<aside class="sidebar-container col-lg-5 col-md-6 noleft">
    <!--<div class="title-bar">

        <h2><strong>KATEGORIE</strong></h2>

    </div>-->


    {# helper.widget('Publication').popularArticles() #}

    {{ helper.staticWidget('ads-box-1') }}
    {{ helper.staticWidget('newsletter-box') }}
</aside>
{# helper.widget('Application').getSubmenu(type_id) #}
</div>

