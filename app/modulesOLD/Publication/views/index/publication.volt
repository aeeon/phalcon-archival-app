<div id="main-content">

    <!--<div class="path">
        
        <a href="#">strona główna</a> 
        <p>&GT;&GT;</p>
        <a href="#">kategoria</a> 
        <p>&GT;&GT;</p>
        <a href="#">podkategoria</a> 
        
    </div>-->

    <div class="content-container col-lg-7 col-md-6 noright">

        <div class="col-lg-12 noleft">

            <div class="title-bar">

                <h1><strong>NAJNOWSZE</strong> POSTY</h1>

            </div>

        </div>

        <div class="page-article-content col-lg-12">
            {% if helper.isAdminSession() %}
            <p style="font-weight: bold;font-size:120%;">
                <a class="noajax"
                   href="{{ url.get() }}publication/admin/edit/{{ publication.getId() }}?lang={{ constant('LANG') }}">{{ helper.at('Edytuj publikację') }}</a>
            </p>
            {% endif %}

            {% if publication.preview_inner %}
            {% set image = helper.image([
            'id': publication.getId(),
            'type': 'publication',
            'width': 845,
            'strategy': 'w'
            ]) %}
            <div class="image inner">
                {{ image.imageHTML('img-responsive') }}
            </div>
            {% endif %}
            <h2>{{ publication.getTitle() }}</h2>
            <div class="cat-info">

                <h3 class="date">{{ publication.getDate('d.m.Y') }}</h3>
                <h3 class="category">{{ publication.getCatTitle(publication.getCategory_id()) }}</h3>

            </div>


            <div class="text-content">
                {{ publication.getText() }}

                <!--   <a href="{{ helper.langUrl(['for':'publications','type':publication.getTypeSlug()]) }}" class="back">&larr; {{ helper.translate('Powrót') }}</a>          -->              

            </div>
            {% set link = helper.langUrl(['for':'publication', 'type':publication.getTypeSlug(), 'slug':publication.getSlug()]) %}
            {{ helper.socialButtons(link, "social") }}

        </div>


        <div class="article-contact-form">

            <form action="#" method="post">

                <h4>POTRZEBUJESZ POMOCY</h4>

                <div class="col-lg-5 col-md-5">

                    <div class="form-group"><input type="text" name="imie_nazwisko" placeholder="Imię, nazwisko"></div>
                    <div class="form-group"><input type="email" name="email" placeholder="Adres e-mail"></div>
                    <div class="form-group"><input type="tel" name="tel" placeholder="Nr telefonu"></div>

                </div>

                <div class="col-lg-5 col-md-5">

                    <textarea name="wiadomosc" placeholder="Treść wiadomości"></textarea>

                    <a href="#">ZADAJ PYTANIE</a>

                </div>

            </form>

        </div>

        {% if publication.getComments_enabled() %}
        <div class="article-comments-box">
            {% if  comments.count() %}
            <div class="comments">

                <div class="title">

                    <i class="fa fa-comment"></i>
                    <h4>KOMENTARZE</h4>

                </div>


                <div class="comments-box">
                    {% for comment in comments %}

                    <div class="comment">

                        <div class="top">

                            <div class="date">{{ comment.getCreatedAt() }}</div>
                            <h5>RE: {{ publication.getTitle() }}?</h5>
                            <div class="author"><i class="fa fa-user"></i>{{ comment.getName() }}</div>

                        </div>

                        <p>{{ comment.getContent() }}</p>

                    </div>
                    {% endfor %}
                </div>

<!--<a id="more-comments" href="#"><i class="fa fa-plus"></i></a>-->

            </div>
            {% endif %}   
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#commentform").submit(function (e) {
                        e.preventDefault(); // avoid to execute the actual submit of the form.
                        $.ajax({
                            url: $(this).attr("action"),
                            type: $(this).attr("method"),
                            dataType: "JSON",
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            success: function (data, status)
                            {
                                var info = $("#commentform-info");
                                info.text("Komentarz został dodany");
                                info.addClass("visible");
                                $("#commentform").attr("style", "display: none");
                            },
                            error: function (xhr, desc, err)
                            {
                                console.log(desc)
                            }
                        });

                    });
                });
            </script>
            <div class="add-comment">

                <div class="title">

                    <i class="fa fa-plus"></i>
                    <h4>DODAJ KOMENTARZ</h4>

                </div>


                <div id="commentform-info"></div>

                {% if comment_form %}
                <form action="{{ url.get() }}comment/add" id="commentform" method="post"  enctype="multipart/form-data">
                    <div class="form-group">{{ comment_form.render('name') }}</div>
                    <div class="form-group">{{ comment_form.render('email') }}</div>

                    <div class="form-group"> {{ comment_form.render('content') }}</div>

                    <div class="form-group">
                        <input type="submit" value="WYŚLIJ">
                    </div>
                    <input type="hidden" name="foreign_key" value="{{ publication.getId() }}">
                    <input type="hidden" name="status" value="1">
                </form> 
                {% endif %}
            </div>

        </div>

        {% endif %} 

        <div class="similar-posts">
            {{ helper.widget('Publication').similarArticles(current_id, cat) }}
        </div>

    </div>
    <aside class="sidebar-container col-lg-5 col-md-6 noleft">

        <div class="title-bar">

            <h2><strong>KATEGORIE</strong></h2>

        </div>

        {{ helper.widget('Application').sidebarMenu(type_id, "top", 'widget/sidebar-menu') }}
        {{ helper.staticWidget('offer-box') }}
        {{ helper.staticWidget('ads-box-1') }}
        {{ helper.staticWidget('newsletter-box') }}
    </aside>

</div>     
