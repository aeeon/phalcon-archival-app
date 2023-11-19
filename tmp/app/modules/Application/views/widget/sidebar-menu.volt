{% if entries %}
<script src="{{ url.path() }}assets/js/category.js"></script> 
<div class="category-box">

    {% for sitem in entries %}

    <a id="a-cat-{{ loop.index }}" href="{{ sitem['entry'].url }}"

       {% if sitem['entry'].newwindow %} target="_blank"{% endif %}><i class="fa fa-plus"></i>{{ sitem['entry'].title }}</a>

    {% if sitem['childs'] %}
    <ul id="box-cat-{{ loop.index }}">
        <li><a href="{{ sitem['entry'].url }}"
               {% if sitem['entry'].newwindow %} target="_blank"{% endif %}><strong>Wszystkie</strong></a></li>
        {% for child in sitem['childs'] %}
        {% if child %}
        <li><a  href="{{ child.url }}"

                {% if child.newwindow %} target="_blank"{% endif %}>{{ child.title }}</a></li>
        {% endif %}
        {% endfor %}
    </ul>
    {% endif %}

    {% endfor %}
</div>
{% endif %}
