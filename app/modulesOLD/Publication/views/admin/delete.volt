<div class="ui segment">
    <a href="{{ url.get() }}publication/admin/edit/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button">
        <i class="icon left arrow"></i> Wróć
    </a>

    <form method="post" class="ui negative message form" action="">
        <p>Usunąć publikację <b>{{ model.getTitle() }}</b>?</p>
        <p><input type="checkbox" name="deleteComments" checked="checked" value="1">
            <label for="deleteComments">Usuń również wszystkie komentarze w tej publikacji</label></p>
        
            <button type="submit" class="ui button negative"><i class="icon trash"></i> Usuń</button>
    </form>

</div>

