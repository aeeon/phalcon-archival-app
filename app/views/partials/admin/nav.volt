

<div class="ui left fixed vertical pointing inverted menu">
    <a class="item{{ helper.activeMenu().activeClass('admin-home') }} header" href="{{ url(['for': 'admin']) }}">
        CMS


    </a>

    <div class="item">
        <div class="header">{{ helper.at('Zawartość') }} <i class="font icon"></i></div>

        <div class="menu">
            {% if helper.isRoleAllowed("page/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-page') }}" href="{{ url.get() }}page/admin">
                {{ helper.at('Strony') }} <i class="file outline icon"></i>
            </a>
            {% endif %}

            {% if helper.isRoleAllowed("publication/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-publication') }}"
               href="{{ url.get() }}publication/admin">
                {{ helper.at('Publikacje') }} <i class="calendar icon"></i>
            </a>
            {% endif %}

            {% if helper.isRoleAllowed("comment/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-comment') }}"
               href="{{ url.get() }}comment/admin">
                {{ helper.at('Komentarze') }} <i class="text file icon"></i>
            </a>    
             {% endif %}

            {% if helper.isRoleAllowed("widget/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-widget') }}" href="{{ url.get() }}widget/admin">
                {{ helper.at('Widgety') }} <i class="text file icon"></i>
            </a>
            {% endif %}

            {% if helper.isRoleAllowed("tree/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('tree') }}" href="{{ url.get() }}tree/admin">
                {{ helper.at('Kategorie') }} <i class="tree icon"></i>
            </a>
            {% endif %}

            {% if helper.isRoleAllowed("treemenu/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('treemenu') }}" href="{{ url.get() }}treemenu/admin">
                {{ helper.at('Menu') }} <i class="tree icon"></i>
            </a>   
            {% endif %}

            {% if helper.isRoleAllowed("file-manager/admin", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-fm') }}" href="{{ url.get() }}file-manager">
                {{ helper.at('Menadżer plików') }} <i class="file image outline icon"></i>
            </a>
            {% endif %}
        </div>
    </div>

    {# <div class="item">
        <div class="header">SEO <i class="lab icon"></i></div>

        <div class="menu">
            <a class="item{{ helper.activeMenu().activeClass('seo-robots') }}" href="{{ url.get() }}seo/robots">
                Robots.txt <i class="android icon"></i>
            </a>
            <a class="item{{ helper.activeMenu().activeClass('seo-sitemap') }}" href="{{ url.get() }}seo/sitemap">
                Sitemap.xml <i class="sitemap icon"></i>
            </a>
            <a class="item{{ helper.activeMenu().activeClass('seo-manager') }}" href="{{ url.get() }}seo/manager">
                SEO Menadżer <i class="lightbulb icon"></i>
            </a>
        </div>
    </div>#}
    <div class="item">

        <div class="header">{{ helper.at('Admin') }} <i class="wrench icon"></i></div>

        <div class="menu">
            {% if helper.isRoleAllowed("admin/admin-user", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-user') }}" href="{{ url.get() }}admin/admin-user">
                {{ helper.at('Użytkownicy') }} <i class="user icon"></i>
            </a>
            {% endif %}
            
            {% if helper.isRoleAllowed("cms/configuration", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-cms') }}" href="{{ url.get() }}cms/configuration">
                {{ helper.at('Konfiguracja') }} <i class="settings icon"></i>
            </a>
            {% endif %}
            
            {# <a class="item{{ helper.activeMenu().activeClass('admin-language') }}" href="{{ url.get() }}cms/language">
                {{ helper.at('Języki') }} <i class="globe icon"></i>
            </a>#}
            
            {% if helper.isRoleAllowed("cms/translate", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-translate') }}" href="{{ url.get() }}cms/translate">
                {{ helper.at('Tłumaczenia') }} <i class="book icon"></i>
            </a>
            {% endif %}
            
            {% if helper.isRoleAllowed("cms/javascript", "index") %}
            <a class="item{{ helper.activeMenu().activeClass('admin-javascript') }}"
               href="{{ url.get() }}cms/javascript">
                {{ '<head>, <body> javascript'|escape }} <i class="code icon"></i>
            </a>
            {% endif %}
        </div>
    </div>
    <div class="item">
        <a href="{{ url.get() }}" class="ui primary tiny button" target="_blank">
            <i class="home icon"></i>{{ helper.at('Podgląd online') }}
        </a>
        <br><br>
        <a href="javascript:void(0);" class="ui tiny button" onclick="document.getElementById('logout-form').submit()">
            <i class="plane icon"></i>{{ helper.at('Wyloguj') }}
        </a>

        <form action="{{ url.get() }}admin/index/logout" method="post" style="display: none;" id="logout-form">
            <input type="hidden" name="{{ security.getTokenKey() }}"
                   value="{{ security.getToken() }}">
        </form>
    </div>
</div>