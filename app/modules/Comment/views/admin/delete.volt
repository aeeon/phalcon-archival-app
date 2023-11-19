<div class="ui segment">
    <a href="{{ url.get() }}page/admin/edit/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button">
        <i class="icon left arrow"></i> {{ helper.at('Wróć') }}
    </a>

    <form method="post" class="ui form segment negative message" action="">
        <p>{{ helper.at('Usuń komentarz użytkownika ') }} <b>{{ model.getName() }}</b>?</p>
        <button type="submit" class="ui button negative"><i class="icon trash"></i> {{ helper.at('Usuń') }}</button>
    </form>

</div>