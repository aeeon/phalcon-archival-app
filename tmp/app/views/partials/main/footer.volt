<div class="container">

    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">

        <div class="top">

            <a class="logo" href="/"></a>

        </div>

        <div class="sep">----</div>

        <div class="content">
            {{ helper.staticWidget('footer-info-box') }}

        </div>

    </div>


    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">

        <div class="top">

            <h4>{{ helper.translate('NASZA OFERTA') }}</h4>

        </div>

        <div class="sep">----</div>

        <div class="content">

            {{  helper.widget('Application').buildMenu("footer1", 'widget/footer-menu') }}

        </div>

    </div>


    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">

        <div class="top">

            <h4>{{ helper.translate('SKONTAKTUJ SIĘ') }}</h4>

        </div>

        <div class="sep">----</div>

        <div class="content">

            {{  helper.widget('Application').buildMenu( "footer2", 'widget/footer-menu') }}

        </div>

    </div>


    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

        <div class="top">

            <h4>{{ helper.translate('NEWSLETTER') }}</h4>

        </div>

        <div class="sep">----</div>

        <div class="content">

            <form action="/newsletter.html" method="post">

                <div class="form-group">

                    <input type="email" name="email" placeholder="Adres e-mail" required>

                </div>

                <div class="form-group">

                    <input type="checkbox" name="zgoda" required>
                    <label>{{ helper.translate('WYRAZAM ZGODE') }}</label>

                </div>

                <div class="form-group">

                    <input type="submit" value="Zapisz">

                </div>

            </form>

        </div>

    </div>

</div> 
