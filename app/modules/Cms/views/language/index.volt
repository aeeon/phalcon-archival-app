<!--controls-->
<div class="ui segment">

    <a href="{{ url.get() }}cms/language/add" class="ui button positive">
        <i class="icon plus"></i> Dodaj nowy
    </a>

</div>
<!--/end controls-->

<table class="ui table very compact celled">
    <thead>
    <tr>
        <th>Nazwa</th>
        <th>Kod</th>
        <th>ISO</th>
        <th>URL</th>
        <th>Kolejność</th>
        <th>Domyślny</th>
        <th>Aktywny</th>
    </tr>
    </thead>
    <tbody>
    {% for item in entries %}
        <tr>
            <td><a href="{{ url.get() }}cms/language/edit/{{ item.getId() }}">{{ item.getName() }}</a></td>
            <td>{{ item.getShort_name() }}</td>
            <td>{{ item.getIso() }}</td>

            {% set url = url.get() %}
            {% if item.getUrl() and not item.getPrimary() %}{% set url = url.get() ~ item.getUrl() ~ '/' %}{% endif %}
            <td><a href="{{ url }}" target="_blank">{{ url }}</a></td>
            <td>{{ item.getSortorder() }}</td>
            <td>{% if item.getPrimary() %}<i class="icon checkmark green"></i>{% endif %}</td>
            <td>{% if item.getActive() %}<i class="icon checkmark greenland"></i>{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>