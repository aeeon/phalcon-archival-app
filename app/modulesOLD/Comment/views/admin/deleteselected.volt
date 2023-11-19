<div class="ui segment">
    <a href="{{ url.get() }}comment/admin?lang={{ constant('LANG') }}" class="ui button">
        <i class="icon left arrow"></i> {{ helper.at('Wróć') }}
    </a>

    <form method="post" class="ui form segment negative message" action="">
        <p>{{ helper.at('Usunąć wszystkie wybrane komentarze') }} ?</p>
            {% for item in items %}
              
                <input type="hidden" name="items[]" value="{{ item}}">
            {% endfor %}
        <button type="submit" class="ui button negative"><i class="icon trash"></i> {{ helper.at('Usuń') }}</button>
    </form>

</div>