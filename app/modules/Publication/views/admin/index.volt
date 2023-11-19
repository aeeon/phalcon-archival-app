<!--controls-->
<div class="ui segment">
    <div class="row">
        <div class="col-md-6">
		{% if(type) %}
            <a href="{{ url.get() }}publication/admin{% if(type) %}/{{ type }}{% endif %}/add" class="ui button positive">
                <i class="icon plus"></i> {{ helper.at('Dodaj nową') }}
            </a>
		{% endif %}
            <a href="{{ url.get() }}publication/type" class="ui button">
                <i class="icon list"></i> {{ helper.at('Typy publikacji') }}
            </a>
        </div>
        <div class="col-md-6 text-right">
            <div style="float:left">
                <form class="ui form" action="" method="GET" id="search-form">
                    <div clas="field">
                    <input type="text" placeholder="Wpisz frazę" name="search" size="40">
                    </div>
                </form>
            </div>
            <div style="float:left;padding-left:2em;">
                <a class="ui primary button" onclick="document.getElementById('search-form').submit()" href="javascript:void(0);">
                    <i class="search icon"></i>
                    Szukaj
                </a>
            </div>
        </div>
    </div>
</div>
<!--/end controls-->

<div class="ui tabular menu">
    <a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}"
       class="item{% if not type_id %} active{% endif %}">{{ helper.at('All') }}</a>
    {% for type_el in types %}
    <a href="{{ url(['for':'publications_admin','type':type_el.getSlug()]) }}?lang={{ constant('LANG') }}&sort=slug&asc={{ asc }}"
       class="item{% if type_el.getId() == type_id %} active{% endif %}">
        {{ type_el.getTitle() }}
    </a>
    {% endfor %}
</div>

{% if paginate.total_items > 0 %}
<table class="ui table very compact celled">
    <thead>
        <tr>
            <th style="width: 100px"></th>
            <th><a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}&sort=title&asc={{ asc }}&type={{ type }}&search={{ search }}"
                   class="item{% if sort == 'title' %} active{% endif %}">{{ helper.at('Title') }}</a></th>            
           <!-- <th><a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}&sort=slug&asc={{ asc }}&type={{ type }}&search={{ search }}"
                   class="item{% if sort == 'slug' %} active{% endif %}">{{ helper.at('Slug') }}</a></th>-->
            <th style="width: 50px;">{{ helper.at('Obrazek') }}</th>
            <th>{{ helper.at('Kategoria') }}</th>
            <th><a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}&sort=status&asc={{ asc }}&type={{ type }}&search={{ search }}"
                   class="item{% if sort == 'status' %} active{% endif %}">{{ helper.at('Status') }}</a></th>
            <th style="width: 150px"><a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}&sort=date&asc={{ asc }}&type={{ type }}&search={{ search }}"
                                        class="item{% if sort == 'date' %} active{% endif %}">{{ helper.at('Data dodania') }}</a></th>
            <th style="width: 150px"><a href="{{ url.get() }}publication/admin?lang={{ constant('LANG') }}&sort=updated_at&asc={{ asc }}&type={{ type }}&search={{ search }}"
                                        class="item{% if sort == 'updated_at' %} active{% endif %}">{{ helper.at('Data aktualizacji') }}</a></th>                                        
            <th>{{ helper.at('Autor') }}</th>
            <th>{{ helper.at('Url') }}</th>
        </tr>
    </thead>
    <tbody>
        {% for item in paginate.items %}
        {% set link = url.get() ~ "publication/admin/edit/" ~ item.getId() %}
        {% set image = helper.image(['id':item.getId(),'type':'publication','width':50]) %}
        <tr>
            <td><a href="{{ link }}?lang={{ constant('LANG') }}" class="mini ui icon button"><i
                        class="icon edit"></i> id = {{ item.getId() }}</a></td>
            <td><a href="{{ link }}?lang={{ constant('LANG') }}">{{ item.getTitle() }}</a></td>            
        <!--    <td><a href="{{ link }}?lang={{ constant('LANG') }}">{{ item.getSlug() }}</a></td>-->
            <td><a href="{{ link }}?lang={{ constant('LANG') }}">{% if image.isExists() %}{{ image.imageHTML() }}{% endif %}</a></td>
            <td>{#  #}</td>
            <td>{{ item.getStatus() }}</td>
            <td>{{ item.getDate() }}</td>
            <td>{{ item.getUpdatedAt() }}</td>
            <td>{{ item.getUsernameById() }}</td>
         <!--  <td>{% if item.getPreviewInner() %}<i class="icon checkmark green"></i>{% endif %}</td>-->
            {% set url = helper.langUrl(['for':'publication', 'type':item.getTypeSlug(), 'slug':item.getSlug()]) %}
            <td><a href="{{ url }}" target="_blank">{{ url }}</a></td>
        </tr>
        {% endfor %}
    </tbody>
</table>
{% else %}
<p>{{ helper.at('Nie odnaleziono wpisów') }}</p>
{% endif %}

{% if paginate.total_pages > 1 %}
<div class="pagination">
    {{ partial('admin/pagination', ['paginate':paginate] ) }}
</div>
{% endif %}
