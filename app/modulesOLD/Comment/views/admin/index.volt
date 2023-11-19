{% if entries|length > 0 %}
<form method="post" class="ui form" action="{{ url.get() }}comment/admin/deleteselected" enctype="multipart/form-data">
    <input type="hidden" name="action" value="confirm">

    <!--controls-->
    <div class="ui segment">

        <div class="ui red submit button">
            <i class="icon trash"></i> {{ helper.at('Usuń zaznaczone') }}
        </div>

    </div>


    <table class="ui table very compact celled">

        <thead>
            <tr>
                <th style="width: 100px"></th>
                <th>Autor</th>
                <th>Status</th>  
                <th>Data dodania</th>
                <th>Publikacja</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            {% for item in entries %}
            {% set link = url.get() ~ "comment/admin/edit/" ~ item.getId() %}
            <tr>
                <td><a href="{{ link }}?lang={{ constant('LANG') }}" class="mini ui icon button"><i class="icon edit"></i>
                        id = {{ item.getId() }}</a></td>
                <td><a href="{{ link }}?lang={{ constant('LANG') }}">{{ item.getName() }}</a></td>
                <td>{% if item.getStatus() %}<i class="icon checkmark green"></i>{% endif %}</td>
                <td>{{ item.getCreatedAt() }}</td>
                {% set slug = item.getPublicationSlug() %}
                {% if slug %}
                {% set url = helper.langUrl(['for':'publication', 'type':item.getTypeSlug(), 'slug':slug]) %}
                <td><a href="{{ url }}" target="_blank">{{ url }}</a></td>
                {% else %}
                <td>Usunięta</td>
                {% endif %}
                <td><input type="checkbox" value="{{ item.getId() }}" name="items[]"></td>
            </tr>

            {% endfor %}
        </tbody>
    </table>
</form>
<script>
    $('.ui.form').form({});
</script>
{% else %}
Brak wpisów
{% endif %}