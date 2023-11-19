{% if entries %} 
<nav id="header-nav">                       

    <div class="main-menu col-lg-8 col-md-12">
        <ul id="main-menu-ul">
            {% for item in entries %}

            {% if item['entry'].status %}
            <li id="menu-item-{{loop.index}}" class="col-lg-2 col-md-2"><img src="/assets/img/menu-item-{{loop.index}}.png">

                {% if item['entry'].custom %}
                <a class="noajax" href="{{ item['entry'].custom }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>

                   {% else %}
                   <a class="noajax" href="{{ item['entry'].url }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>
                   {% endif %}
                   {{ item['entry'].title }}

                </a>

                {#
                {% if item['subentries'] %}
                <ul>
                    {% for sitem in item['subentries'] %}
                    <li>
                        {% if item['entry'].custom %}
                        <a class="noajax" href="{{ sitem['entry'].custom }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>{{ sitem['entry'].title }}</a>
                        {% else %}
                        <a class="noajax" href="{{ sitem['entry'].url }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>{{ sitem['entry'].title }}</a>
                        {% endif %}
                        {% if sitem['childs'] %}
                        <ul>
                            {% for child in sitem['childs'] %}
                            {% if child %}
                            <li><a class="noajax" href="{{ child.url }}" {% if child.newwindow %} target="_blank"{% endif %}>{{ child.title }}</a></li>
                            {% endif %}
                            {% endfor %}
                        </ul>
                        {% endif %}
                    </li>
                    {% endfor %}
                </ul>
                {% endif %}
                #}
        </li>
        {% endif %}
        {% endfor %}
    </ul>

    <i id="show-menu" class="fa fa-bars"></i>
</div>
<div class="sidebar-header-menu col-lg-4 hidden-md">
    <div class="header-search col-lg-5 nopad">
        <ul>
            <li class=" search-form">
                <form method="POST" action="/publication/wyszukaj">
                    <input class="input-search" type="text" name="search" value="" required>
                    <i class="fa fa-search"></i>
                </form>
            </li>
        </ul>
    </div>
    <div class="col-lg-7 noright social-menu">
        <ul>
            <li class="col-lg-3"><a href="https://www.facebook.com/jakprawnie"><i class="fa fa-facebook"></i></a>
            </li>
            <a href="https://twitter.com/jakprawnie"><li class="col-lg-3"><i class="fa fa-twitter"></i></a>
            </li>
            <!--  <li class="col-lg-3"><i class="fa fa-google-plus"></i>
            </li>-->
            <li class="col-lg-3"><a href="{{ url.path()}}rss/news.rss"><i class="fa fa-rss"></i></a>
            </li>
        </ul>    

        <a id="show-social" href="#"></a>
    </div>
</div>
</nav>
{% endif %}

{% if entries %}                        

<nav class="mobile-menu">
    <ul>
        {% for item in entries %}
        {% if item['entry'].status %}

        {% if loop.index == 5 %}
        <li><a id="a-mobile-oferta" href="{{ item['entry'].custom }}">{{ item['entry'].title }}</a></li> 
        <li class="mobile-submenu" id="box-mobile-oferta">

            <ul>

                <li><a href="/oferta.html">Dla firm</a></li>
                <li><a href="/oferta2.html">Dla osób fizycznych</a></li>

            </ul>

        </li> 
        {% else %}
        <li>
            {% if item['entry'].custom %}

            <a class="noajax" href="{{ item['entry'].custom }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>
               {% else %}
               <a class="noajax" href="{{ item['entry'].url }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>
               {% endif %}
               {{ item['entry'].title }}

            </a>

    </li>
    {% endif %}
    {% endif %}
    {% endfor %}

</ul>

</nav>
{% endif %}


{% if entries %}                        


{% for item in entries %}
{% if item['entry'].status %}

{% if item['subentries'] %}
{% set i = loop.index %}
<div class="dropdown" id="dropdown-menu-item-{{ loop.index }}">
    {% if i == 5 %}

    <div class="col-lg-6 col-md-6 border-r">

        <div class="col-lg-6 col-md-6 border-r">
            <a class="title-link" href="/oferta.html">

                <img src="/assets/img/dla-firm-menu-img.png" alt="">
                <h4>DLA FIRM</h4>

            </a>


            <nav class="alt-nav">

                <ul>

                    <li><a href="/oferta.html#stala-obsluga">Stała obsługa<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#zlec-umowe">Zleć umowę<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#e-porada">E-porada<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#zlec-pismo">Zleć pismo<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#zlec-sprawe">Zleć sprawę<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#zakladanie-spolek">Zakładanie społek<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#regulaminy-giodo">Regulaminy www GIODO<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta.html#windykacja">Windykacja<i class="fa fa-angle-right"></i></a></li>

                </ul>

            </nav>

            <a class="see-all-2" href="/oferta.html">DOWIEDZ SIĘ WIĘCEJ</a>

        </div>


        <div class="col-lg-6 col-md-6">

            <a class="title-link" href="/oferta2.html">

                <img src="/assets/img/dla-osob-fizycznych-menu-img.png" alt="">
                <h4>DLA OSÓB FIZYCZNYCH</h4>

            </a>


            <nav class="alt-nav">

                <ul>

                    <li><a href="/oferta2.html#zlec-pismo">Zleć pismo<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta2.html#zlec-sprawe">Zleć sprawę<i class="fa fa-angle-right"></i></a></li>
                    <li><a href="/oferta2.html#e-porada">E-porada<i class="fa fa-angle-right"></i></a></li>

                </ul>

            </nav>

            <a class="see-all-2" href="/oferta2.html">DOWIEDZ SIĘ WIĘCEJ</a>

        </div>

    </div>


    <!-- <div class="col-lg-6 col-md-6">

         <div class="title-box">

             <img src="/assets/img/zadaj-pytanie-menu-img.png" alt="">
             <h4>ZADAJ PYTANIE NASZYM SPECJALISTOM</h4>

         </div>


         <div class="col-lg-4 col-md-4">
         <a href="#">

             <img class="img-circle" src="/assets/img/osoba1.jpg" alt="">
             <h6>Adw. Jan Kowalski</h6>
             <p>Specjalność: <strong>prawo gospodarcze</strong></p>

             <div class="zadaj-pytanie">ZADAJ PYTANIE</div>

         </a>
         </div>

         <div class="col-lg-4 col-md-4">
         <a href="#">

             <img class="img-circle" src="/assets/img/osoba2.jpg" alt="">
             <h6>Radca Prawny Agata Nowak</h6>
             <p>Specjalność: <strong>prawo rodzinne</strong></p>

             <div class="zadaj-pytanie">ZADAJ PYTANIE</div>

         </a>
         </div>

         <div class="col-lg-4 col-md-4">
         <a href="#">

             <img class="img-circle" src="/assets/img/osoba3.jpg" alt="">
             <h6>Krzysztof Kamiński</h6>
             <p>Specjalność: <strong>prawo autorskie</strong></p>

             <div class="zadaj-pytanie">ZADAJ PYTANIE</div>

         </a>
         </div>

     </div> -->
    {% else %}
    <div class="col-lg-6 col-md-6 border-r">   


        <div class="col-lg-6 col-md-6">

            <nav class="left-nav">
                <ul>               

                    {% for sitem in item['subentries'] %}
                    {% if sitem['entry'].status %}

                    <li>                    
                        {% if sitem['entry'].custom %}
                        <a class="menu-second-level" id="a-pdk{{i}}-{{loop.index}}" href="{{ sitem['entry'].custom }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>
                           {% else %}
                           <a class="menu-second-level" id="a-pdk{{i}}-{{loop.index}}" href="{{ sitem['entry'].url }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>
                           {% endif %}
                           {{ sitem['entry'].title }}

                           <i class="fa fa-angle-right"></i></a>
                            <div class="submenu" id="box-pdk{{i}}-{{loop.index}}">

                                {% if sitem['childs'] %}
                                <ul>
                                    {% for child in sitem['childs'] %}
                                    {% if child %}
                                    <li><a href="{{ child.url }}" {% if child.newwindow %} target="_blank"{% endif %}>{{ child.title }}</a></li>
                                    {% endif %}
                                    {% endfor %}
                                </ul>
                                <a class="see-all" href="{{ sitem['entry'].url }}">ZOBACZ WSZYSTKIE</a>
                                {% endif %}
                            </div>
                    </li>
                    {% endif %}

                    {% endfor %}
                </ul>

            </nav>

        </div>

    </div> 


    <div class="col-lg-6 col-md-6">

        {% if item['entry'].typ == 'category' %}

        {{ helper.widget('Publication').lastNews(item['entry'].type) }}



        <a class="see-all-2" href="{{ item['entry'].url }}">ZOBACZ WSZYSTKIE</a>
        {% endif %}
    </div>
    {% endif %}

</div>              
{% endif %}
{% endif %}
{% endfor %}

{% endif %}