<form method="post" class="ui form" action="" enctype="multipart/form-data">

    <!--controls-->
    <div class="ui segment">

        <a href="{{ url.get() }}comment/admin?lang={{ constant('LANG') }}" class="ui button">
            <i class="icon left arrow"></i> {{ helper.at('Wróć') }}
        </a>

        <div class="ui positive submit button">
            <i class="save icon"></i> {{ helper.at('Zapisz') }}
        </div>

        {% if model.getId() %}

            <a href="{{ url.get() }}comment/admin/delete/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button red">
                <i class="icon trash"></i> {{ helper.at('Usuń') }}
            </a>

        {% endif %}

    </div>
    <!--end controls-->

    <div class="ui segment">
        {{ form.renderDecorated('name') }}
        {{ form.renderDecorated('email') }}
        {{ form.renderDecorated('content') }}
        {{ form.renderDecorated('created_at') }}
         {{ form.renderDecorated('status') }}
    </div>

</form>

<script>
    $('.ui.form').form({});
</script>

<script type="text/javascript" src="{{ url.get() }}vendor/tiny_mce_3/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        selector : "#text",
        language: "en", // "pl"
        height: "500px",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,charmap,iespell,media,advhr,",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,fullscreen",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        theme_advanced_blockformats : "p,h1,h2,h3,h4",
        theme_advanced_font_sizes: "9px,10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px",

        browser_spellcheck : true,

        relative_urls : false,
        convert_urls : true,

        element_format : "html5",

        file_browser_callback : 'elFinderBrowser_3',

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "{{ url.get() }}static/css/tinymce.css"
    });
</script>