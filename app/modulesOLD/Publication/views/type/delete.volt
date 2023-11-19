<div class="ui segment">
    <a href="{{ url.get() }}publication/type/edit/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button">
        <i class="icon left arrow"></i> Wróć
    </a>
</div>

<form method="post" class="ui negative message form" action="">
    <p>Usunąć <b>{{ model.getTitle() }}</b>?</p>
    <button type="submit" class="ui button negative"><i class="icon trash"></i> Usuń</button>
</form>