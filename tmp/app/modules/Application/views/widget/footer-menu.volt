{% if entries %}
<ul id="menu">
    {% for item in entries %}
    <li>
        {% if item['entry'].custom %}
        <a class="noajax" href="{{ item['entry'].custom }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>

           {% else %}
           <a class="noajax" href="{{ item['entry'].url }}" {% if item['entry'].newwindow %} target="_blank"{% endif %}>
           {% endif %}
           {{ item['entry'].title }}

        </a>
        {% if item['subentries'] %}
        <ul>
            {% for sitem in item['subentries'] %}
            <li>
                {% if sitem['entry'].custom %}
                <a class="noajax" href="{{ sitem['entry'].custom }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>{{ sitem['entry'].title }}</a>
                {% else %}
                <a class="noajax" href="{{ sitem['entry'].url }}" {% if sitem['entry'].newwindow %} target="_blank"{% endif %}>{{ sitem['entry'].title }}</a>
                {% endif %}
                {% if sitem['childs'] %}
                <ul>
                    {% for child in sitem['childs'] %}
                    {% if child %}
                    <li><a class="noajax" href="{{ child.url }}" {% if child.newwindow %} target="_blank"{% endif %}>{{ child.title }}</a></li>
                    {% endif %}
                    {% endfor %}
                </ul>
                {% endif %}
            </li>
            {% endfor %}
        </ul>
        {% endif %}
</li>
{% endfor %}
</ul>
{% endif %}

