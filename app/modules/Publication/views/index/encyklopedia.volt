<div id="main-content">
    <script src="{{ url.path() }}assets/js/encyklopedia.js"></script>
    <!--<div class="path">
        
        <a href="#">strona główna</a> 
        <p>&GT;&GT;</p>
        <a href="#">encyklopedia prawa</a> 
        
    </div>-->

    <div class="content-container col-lg-7 col-md-6 noright">

        <div class="col-lg-12 noleft">

            <div class="title-bar title-bar-encyklopedia">

                <div class="content">

                    <h1>ENCYKLOPEDIA<br>PRAWA</h1>

                    <nav>
                        <?php //print_r($helper->alfabet()); ?>
                        <ul>
                            {% for letter in helper.alfabet() %}
                            <li><a href="{{ url.path() ~ "encyklopedia/" ~ letter}}">{{ letter }}</a></li>
                            {% endfor %}

                        </ul>

                    </nav>

                </div>

            </div>

        </div>


        <div class="encyklopedia-box">

            <div class="col-lg-3 col-md-3 col-sm-12">

                <form action="{{ url.path }}encyklopedia" method="get">
                    <input list="slownik" type="text" name="key" required placeholder="Szukaj">

                    <datalist id="slownik">
                        {% for item in all %}
                        <option name="{{ loop.index }}" value="{{ item.getTitle() }}">
                            {% endfor %}
                    </datalist>

                    <input type="submit" id="std_szukaj" style="display: none;">
                    <i id="szukaj" class="fa fa-search"></i>

                </form>

                <ul>
                    {% for item in publications %}
                    <li id="a-{{ loop.index}}"><a href="javascript:void(0)">{{ item.getTitle() }}</a></li>
                    {% endfor %}
                </ul>

            </div>


            <div class="col-lg-8 col-md-8" id="encyklopedia-content">
                {% for item in publications %}
                <div class="box" id="box-{{ loop.index}}">

                    <h2>{{ item.getTitle()}}</h2>

                    <div class="content">
                        {{ item.getText() }}
                    </div>

                    {% if !loop.first %}
                    <a class="prev" href="javascript:void(0)" data-index="{{ loop.index-1 }}"><i class="fa fa-caret-left"></i>Poprzednie hasło</a>
                    {% endif %}

                    {% if !loop.last %}
                    <a class="next" href="javascript:void(0)" data-index="{{ loop.index+1 }}">Następne hasło<i class="fa fa-caret-right"></i></a>
                    {% endif %}
                </div>
                {% elsefor %}
                Brak elementów do wyświetlenia
                {% endfor %}

            </div>

        </div>


    </div>
    <aside class="sidebar-container col-lg-5 col-md-6 noleft">

        {{ helper.staticWidget('offer-box') }}
        {{ helper.staticWidget('newsletter-box') }}
        {{ helper.staticWidget('ads-box-1') }}




    </aside>


</div>
