{% if entries %}
<div class="category-box">

    {% for sitem in entries %}

    <a id="a-cat-{{ loop.index }}" href="{{ sitem['entry'].url }}"

       {% if helper.isUriActive(sitem['entry'].url) %} class="active" {% endif %} 
       {% if sitem['entry'].newwindow %} target="_blank"{% endif %}><i class="fa fa-plus"></i>{{ sitem['entry'].title }}</a>

    {% if sitem['childs'] %}
    <ul id="box-cat-{{ loop.index }}"  
       {% if helper.isUriActive(sitem['entry'].url) %} style="display: block" {% endif %} >
        <li><a href="{{ sitem['entry'].url }}"
           {% if sitem['entry'].newwindow %} target="_blank"{% endif %}><strong>Wszystkie</strong></a></li>
        {% for child in sitem['childs'] %}
        {% if child %}
        <li><a  href="{{ child.url }}"
                {% if helper.isUriActive(child.url) %} style="font-weight: bold" {% endif %} 
                {% if child.newwindow %} target="_blank"{% endif %}>{{ child.title }}</a></li>
        {% endif %}
        {% endfor %}
    </ul>
    {% endif %}

    {% endfor %}
</div>
{% endif %}
