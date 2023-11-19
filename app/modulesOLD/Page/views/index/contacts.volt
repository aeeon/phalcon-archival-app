<div id="main-content">
    <div class="content-container col-lg-7 col-md-6 noright">

        <div class="col-lg-12 noleft">

            <div class="title-bar title-bar-kontakt">

                <h1><strong>KONTAKT</strong></h1>

            </div>


            {{ flash.output() }}
            <div class="kontakt-box">
                {{ page.getText() }}
                <div class="contact-form">

                    <form action="/kontakt.html" method="post">

                        <h4>POTRZEBUJESZ POMOCY</h4>

                        <div class="col-lg-5 col-md-5">

                            <div class="form-group"><input type="text" name="imie_nazwisko" placeholder="Imię, nazwisko" required></div>
                            <div class="form-group"><input type="email" name="email" placeholder="Adres e-mail" required></div>
                            <div class="form-group"><input type="tel" name="tel" placeholder="Nr telefonu" required></div>

                        </div>

                        <div class="col-lg-5 col-md-5">

                            <textarea name="wiadomosc" placeholder="Treść wiadomości" required></textarea>

                            <input type="submit" value="ZADAJ PYTANIE">

                        </div>

                    </form>

                </div>
                {{ helper.staticWidget('contact-info-box') }}


            </div>

        </div>
    </div>


    <aside class="sidebar-container col-lg-5 col-md-6 noleft">
        {{ helper.staticWidget('offer-box') }}
        {{ helper.staticWidget('ads-box-1') }}
        {{ helper.staticWidget('newsletter-box') }}
    </aside>
</div>