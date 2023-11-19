{% set image = helper.image([
'id': item.getId(),
'type': 'publication',
'width': 300,
'height': 120,
'strategy': 'w'
]) %}
{% set link = helper.langUrl(['for':'publication', 'type':item.getTypeSlug(), 'slug':item.getSlug()]) %}
{% if image.isExists() %}{% set imageExists = true %}{% else %}{% set imageExists = false %}{% endif %}
<div class="col-lg-6 col-md-6 col-sm-6 article-col">
    <div class="article-item">
        {% if imageExists %}
        
        <a class="image" href="{{ link }}">
         
            <div style="background-image: url('{{ url.get() }}{{ image.originalRelPath() }}'); background-size: cover; background-position: center center; width: 100%; height: 120px; background-repeat: no-repeat"></div>
            {# image.imageHTML("img-responsive") #}</a>
        {% endif %}

        <a href="{{ link }}" title="{{ item.getTitle()|escape_attr }}"><h3>{{ item.getTitle() }}</h3></a>
        <p><span class="data">{{ item.getDate('d.m.Y') }}</span> |<span class="kategoria">
                {% set catTitle =  item.getCatTitle(item.getCategory_id()) %}
         
                <a href="{{ helper.getCatUrlById(item.getCategory_id(), item.getTypeSlug()) }}" title="{{ catTitle}}"> {{ catTitle }}</a>
            </span></p>
       <p><a class="more-content" href="{{ link }}">{{ helper.announce(item.getExcerpt(), 200) }}</a>
           <a class="read-more" href="{{ link }}">{{ helper.translate('czytaj więcej') }}&nbsp;&raquo;</a>
        </p></a>
    </div>
    
    {{ helper.socialButtons(link, "article-social-buttons") }}

</div>
