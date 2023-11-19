<!--controls-->
<div class="ui segment">

    <a href="{{ url.get() }}admin/admin-user/add" class="ui button positive">
        <i class="icon plus"></i> {{ helper.at('Dodaj') }}
    </a>

</div>
<!--/end controls-->

<table class="ui table very compact celled">
    <thead>
    <tr>
        <th style="width: 100px"></th>
        <th>{{ helper.at('Login') }}</th>
        <th>{{ helper.at('Email') }}</th>
        <th>{{ helper.at('Imię i nazwisko') }}</th>
        <th>{{ helper.at('Rola') }}</th>
        <th>{{ helper.at('Aktywny') }}</th>
    </tr>
    </thead>
    <tbody>
    {% for user in entries %}
        <tr>
            {% set url = url.get() ~ 'admin/admin-user/edit/' ~ user.getId() %}
            <td><a href="{{ url }}" class="mini ui icon button"><i class="pencil icon"></i></a></td>
            <td><a href="{{ url }}">{{ user.getLogin() }}</a></td>
            <td>{{ user.getEmail() }}</td>
            <td>{{ user.getName() }}</td>
            <td>{{ user.getRoleTitle() }}</td>
            <td>{% if user.getActive() %}<i class="icon checkmark green"></i>{% endif %}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>