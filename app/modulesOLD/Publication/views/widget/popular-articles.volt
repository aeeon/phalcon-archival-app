{% if entries %}
<div id="most-popular-box">
    <h2><span class="bold">Najczęściej</span> czytane</h2>
    {% for item in entries %}
    {% set url = helper.langUrl([
    'for':'publication',
    'type':item.getTypeSlug(),
    'slug':item.getSlug()
    ]) %}
    {% set image = helper.image([
    'id':item.getId(),
    'type':'publication',
    'width': 185,
    'strategy': 'w'
    ],[
    'alt':item.getTitle()|escape_attr
    ]) %}
    <div class="most-popular-item">
        <div class="col-lg-4 col-md-4 col-sm-6">
            {% if image.isExists() %}
            <a href="{{ url }}" title="{{ item.getTitle()|escape_attr }}" class="image" rel="nofollow">
                {{ image.imageHTML('img-responsive') }}
            </a>
            {% endif %}
        </div>
        <aside class="col-lg-8 col-md-8 col-sm-6">
            <a href="{{ url }}" title="{{ item.getTitle()|escape_attr }}"><h3>{{ item.getTitle() }}</h3></a>
            {# <p><a class="more-content" href="{{ url }}">{{ helper.announce(item.getExcerpt(), 100) }}</a>
                <a class="read-more" href="{{ url }}">{{ helper.translate('czytaj więcej') }}&nbsp;&raquo;</a></p>#}
        </aside>
    </div>   
    {% endfor %}
</div>
{% endif %}