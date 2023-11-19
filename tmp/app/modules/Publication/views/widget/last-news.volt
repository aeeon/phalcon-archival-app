{% if entries %}

    <h5>{{ helper.translate('Najnowsze artykuły') }}</h5>

    {% for item in entries %}
    {% set url = helper.langUrl([
    'for':'publication',
    'type':item.getTypeSlug(),
    'slug':item.getSlug()
    ]) %}
    {% set image = helper.image([
    'id':item.getId(),
    'type':'publication',
    'width': 152,
    'strategy': 'w'
    ],[
    'alt':item.getTitle()|escape_attr
    ]) %}
<div class="col-lg-6 col-md-6 article-box">


    {% if image.isExists() %}
    <a href="{{ url }}" title="{{ item.getTitle()|escape_attr }}" class="title"><div class="last-article-image"
       style="background-image: url('{{ url.get() }}{{ image.originalRelPath() }}');">
 
        </div></a>
    {% endif %}

    <a href="{{ url }}" title="{{ item.getTitle()|escape_attr }}" class="title">
        <h4>{{ item.getTitle() }}</h4>
    </a>

    <p>
    {#        <a class="more-content" href="{{ link }}"> {{ helper.announce(item.getExcerpt(), 100) }}</a> 

        <a href="{{ url }}" title="{{ item.getTitle()|escape_attr }}" class="read-more" rel="nofollow">{{ helper.translate('czytaj więcej') }}</a></p> #}
</div>
    {% endfor %}


{% endif %}