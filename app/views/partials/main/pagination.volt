{% set link = url.get() ~ substr(router.getRewriteUri(), 1) %}


<div class="col-lg-3 noleft pagination-prev">
    {% if paginate.current !== paginate.before %} 
    <i class="fa fa-caret-left"></i>
    <a class="prev"  href="{{ link }}?page={{ paginate.before }}">Poprzednia</a>
    {% endif %}
</div>

<div class="pagination-list col-lg-6 text-center hidden-md">
    <div class="ui pagination menu">
        <a class="icon item" href="{{ link }}?page={{ paginate.before }}">
            <i class="left arrow icon"></i>
        </a>
        {% if paginate.total_pages > 10 %}
        {% if paginate.current > 5 %}
        {% for i in paginate.current-4..paginate.current+5 %}
        {% if i <= paginate.total_pages %}
        <a class="item{% if paginate.current == i %} active{% endif %}"
           href="{{ link }}?page={{ i }}">{{ i }}</a>
        {% endif %}
        {% endfor %}
        {% else %}
        {% for i in 1..10 %}
        <a class="item{% if paginate.current == i %} active{% endif %}"
           href="{{ link }}?page={{ i }}">{{ i }}</a>
        {% endfor %}
        {% endif %}
        {% else %}
        {% for i in 1..paginate.total_pages %}
        <a class="item{% if paginate.current == i %} active{% endif %}" href="{{ link }}?page={{ i }}">{{ i }}</a>
        {% endfor %}
        {% endif %}
        <a class="icon item" href="{{ link }}?page={{ paginate.next }}">
            <i class="right arrow icon"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 pagination-next text-right">
   
{% if paginate.current !== paginate.next %}
    <a class="prev"  href="{{ link }}?page={{ paginate.next }}">Następna</a>
    <i class="fa fa-caret-right"></i>
    {% endif %}
</div> 
