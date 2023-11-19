<div id="main-content">

    <!-- <div class="path">
         
         <a href="#">strona główna</a> 
         <p>&GT;&GT;</p>
         <a href="#">podstrona</a> 
         
     </div>-->

    <div class="title-bar-wycena">
        <h1><strong>Formularz</strong> kontaktowy</h1>
    </div>


    <script>
        $(document).ready(function () {
            $('#addFile').click(function () {
                var max = 5;
                var last = $("#filesContainer input").last().attr("data-index");
                if (!last)
                    last = 0;
                if (last >= max) {
                    alert("Maksymalna ilość załączników wynosi 5!");
                    return;
                }
                $('#filesContainer').append(
                        $('<input/>').attr('type', 'file').attr('name', 'file' + (parseInt(last) + 1)).attr('data-index', parseInt(last) + 1).attr('class', 'file-input')
                        );
            });
        });

    </script>    


    <div id="formularz-wycena" class="zapytanie-box">

        {{ flash.output() }}

        {% if form %}
        <br>
        <form action="{{ url.get }}/page/index/wycena" method="post" enctype="multipart/form-data">
            <div class="col-lg-4 col-md-4">

                <div class="title">

                    <img src="/assets/img/zapytanie-1.png" alt="">
                    <i class="fa fa-user"></i>
                    <h2>Wprowadź dane</h2>

                </div>        

                <div class="content">

                    <div class="form-group">{{ form.render('name') }}</div>
                    <div class="form-group">{{ form.render('email') }}</div>
                    <div class="form-group">{{ form.render('phone') }}</div>

                </div>

            </div>

            <div class="col-lg-4 col-md-4">

                <div class="title">

                    <img src="/assets/img/zapytanie-2.png" alt="">
                    <i class="fa fa-pencil"></i>
                    <h2>Opisz problem</h2>

                </div>        

                <div class="content">

                    <div class="form-group">{{ form.render('text') }}</div>

                    <div class="form-group">

                        <div class="zalaczniki">

                            <p>załącz plik (maksymalnie 5 plików) o rozmiarze do 5MB</p>

                            <div id="filesContainer">

                            </div>

                            <a href="javascript:void(0)" id="addFile" class="add-file">Dodaj załącznik</a>


                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-4">

                <div class="title">

                    <img src="/assets/img/zapytanie-3.png" alt="">
                    <i class="fa fa-envelope-o"></i>
                    <h2>Wyślij zapytanie</h2>

                </div>        

                <div class="content">

                    <div class="form-group">

                        {{ form.render('zgoda1') }}
                        <label for="zgoda1">Chcę otrzymać bezpłatną wycenę mojego problemu, akceptuję regulamin usługi oraz regulamin serwisu.</label>

                    </div>

                    <div class="form-group extra-top">

                        {{ form.render('zgoda2') }}
                        <label for="zgoda2">Wyrażam zgodę na przetwarzanie moich danych osobowych w celu wykonania zobowiązań przez zgodnie z ustawą z 29 sierpnia 1997 r. o ochronie danych osobowych. </label>

                    </div>

                    <div class="form-group">

                        <input type="submit" value="WYŚLIJ">

                    </div>

                </div>

            </div>

        </form>
        {% endif %}

    </div>

</div>


