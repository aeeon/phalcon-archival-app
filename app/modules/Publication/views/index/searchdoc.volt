<div id="main-content">

    <div class="content-container col-lg-7 col-md-6 noright">
        <div class="col-lg-12 noleft">

            <div class="title-bar title-bar-wzory">

                <div class="content">

                    <h1>SZYBKA WYSZUKIWARKA WZORÓW</h1>

                    <form action="/publication/wyszukajdoc" method="post">

                        <input type="text" name="search" required>
                        <input type="submit" id="std_szukaj_wzorow" style="display: none;">
                        <i id="szukaj_wzorow" class="fa fa-search"></i>

                    </form>

                </div>

            </div>

        </div>        
        <div id="newest-post-box" class="{{ format }}">

            {% if search  %}
            <p>Wyszukiwana fraza: {{ search }}</p>

            {% if paginate.total_items > 0 %}
            {% for item in paginate.items %}

            <div class="text">
                <a href="{{ url.path() ~ item.getPath() }}" class="title">{{ item.getTitle() }}</a>

            </div>
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

    {{ helper.staticWidget('ads-box-1') }}
    {{ helper.staticWidget('newsletter-box') }}
</aside>
</div>
