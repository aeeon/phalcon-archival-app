{% if entries.count() > 0 %}

<h4><strong>ZOBACZ</strong> PODOBNE POSTY</h4>

{% for item in entries %}
{% set url = helper.langUrl([
'for':'publication',
'type':item.getTypeSlug(),
'slug':item.getSlug()
]) %}
<div class="post item{% if imageExists %} with-image{% endif %}">
    {% set image = helper.image([
    'id': item.getId(),
    'type': 'publication',
    'width': 200,
    'strategy': 'w'
    ]) %}
    {% set link = helper.langUrl(['for':'publication', 'type':item.getTypeSlug(), 'slug':item.getSlug()]) %}
    {% if image.isExists() %}{% set imageExists = true %}{% else %}{% set imageExists = false %}{% endif %}
    {% if imageExists %}
    <a class="image" href="{{ link }}">{{ image.imageHTML() }}</a>
    {% endif %}

    <a href="{{ link }}" title="{{ item.getTitle()|escape_attr }}"><h5>{{ item.getTitle() }}</h5></a>

    <p><a class="more-content" href="{{ link }}">{{ helper.announce(item.getExcerpt(), 200) }}</a>
        <a class="read-more" href="{{ link }}">{{ helper.translate('czytaj więcej') }}&raquo;</a></p>

</div>

{% endfor %}
<a class="see-more" href="#">ZOBACZ WIĘCEJ <i class="fa fa-plus"></i></a>


{% endif %}