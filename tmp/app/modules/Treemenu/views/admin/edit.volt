<form action="{{ url.get() }}treemenu/admin/edit/{{ model.getId() }}" method="post" class="ui form">

    <!--controls-->
    <div class="ui segment">

        <a href="{{ url.get() }}treemenu/admin?lang={{ constant('LANG') }}" class="ui button">
            <i class="icon left arrow"></i> {{ helper.at('Wróć') }}
        </a>

        <div class="ui positive submit button">
            <i class="save icon"></i> {{ helper.at('Zapisz') }}
        </div>

    </div>
    <!--end controls-->

    <div class="ui segment">
        <div class="two fields">
            <div class="field">
                {{ form.renderDecorated('data') }}
            </div>
            <div class="field">
                {{ form.renderDecorated('title') }}
            </div>


        </div>
        <div class="two fields">
            <div class="field">
                {{ form.renderDecorated('custom') }}
            </div>
            <div class="field">
                {{ form.renderDecorated('newwindow') }}
            </div>            
           
        </div>
        <div class="two fields">
         
            <div class="field">
                {{ form.renderDecorated('auto') }}
            </div>
            <div class="field">
                {{ form.renderDecorated('status') }}
            </div>            
        </div>        
    </div>

</form>

<!--ui semantic-->
<script>
    $('.ui.form').form({
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {type: 'empty'}
                ]
            }
        }
    });
</script><!--/end ui semantic-->