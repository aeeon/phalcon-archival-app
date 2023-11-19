<div id="main-content">

    <div class="content-container col-lg-7 col-md-6 noright">
        <div id="newest-post-box" class="{{ format }}">
            <div class="col-lg-12 noleft">
                <div class="title-bar">
                    <!--<h1>{{ title }}</h1>-->
                    <h1>{{ title }}</h1>
                </div>

            </div>


            {% if paginate.total_items > 0 %}
            {% for item in paginate.items %}

            {{ helper.modulePartial('index/format/' ~ format, ['item':item]) }}
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
        <div class="title-bar">

            <h2><strong>KATEGORIE</strong></h2>

        </div>
   
        {{ helper.widget('Application').sidebarMenu(dzial, "top", 'widget/sidebar-menu') }}
        {# helper.widget('Publication').popularArticles() #}
  
        {{ helper.staticWidget('ads-box-1') }}
        {{ helper.staticWidget('newsletter-box') }}
    </aside>
    {# helper.widget('Application').getSubmenu(type_id) #}
</div>
