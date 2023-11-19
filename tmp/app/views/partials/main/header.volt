{% set languages = helper.languages() %}
{% if languages|length > 1 %}
    <div class="languages">
        {% for language in languages %}
            <div class="lang">
                {{ helper.langSwitcher(language['iso'], language['name']) }}
            </div>
        {% endfor %}
    </div>
{% endif %}

             <div id="main-ads-content"></div>
                <div id="header-top">

                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide slide1"></div>
                            <div class="swiper-slide slide2"></div>
                            <div class="swiper-slide slide3"></div>
                        </div>
                        <!-- Add Pagination -->

                        <!--<div class="swiper-pagination"></div>-->
                    </div>                        


                    <div class="inner-content">
                        <div class="logo col-lg-8 col-md-6">
                            <div class="inner">
                                <h1><a class="noajax" href="{{ url.get() }}"><span class="first">Jak</span>prawnie<span class="last">.pl</span></a></h1>

                                <h2 class="slide-entry slide-entry-0 active">Potrzebujesz<br>porady prawnej?<br>Zadaj pytanie.</h2>
                                <h2 class="slide-entry slide-entry-1">Potrzebujesz<br>porady prawnej?<br>Zadaj pytanie.</h2>
                                <h2 class="slide-entry slide-entry-2">Potrzebujesz<br>porady?<br>Zadaj pytanie.</h2>
                            </div>
                        </div>
                        <div class="porada-form col-lg-4 col-md-6">
                            <div class="inner">
                                <h3>Porada prawna on-line</h3>
                                <form class="" action="/wycena.html#formularz-wycena" method="post">
                                    <ul>
                                        <!--<li><input type="text" value="" placeholder="Imię, Nazwisko"></li>-->
                                        <li><input type="text" value="" placeholder="E-mail"></li>
                                        <li> <textarea rows="4" cols="10" placeholder="Treść"></textarea></li>
                                        <li class="text-right"><input type="submit" value="Wyślij zapytanie"></li>
                                    </ul>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
