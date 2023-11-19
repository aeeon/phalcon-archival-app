<div class="ui segment">
    <a href="{{ url.get() }}cms/language/edit/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button">
        <i class="icon left arrow"></i> Wróć
    </a>

    <form method="post" class="ui negative message form" action="">
        <p>Usuń język <b>{{ model.getName() }} - {{ model.getIso() }}</b>?</p>
        <button type="submit" class="ui button negative"><i class="icon trash"></i> Usuń</button>
    </form>

</div>