<form method="post" class="ui form" action="" enctype="multipart/form-data">

<!-- include jQuery and jQueryUI libraries -->
<!--<script type="text/javascript" src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.min.css"/>
-->
<!-- include plugin -->
<!--<script type="text/javascript" src="{{ url.get() }}vendor/jquery-tree/jquery.tree.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ url.get() }}vendor/jquery-tree/jquery.tree.min.css" />
-->

    <!--controls-->
    <div class="ui segment">

        <a href="{{ url.get() }}publication/admin{% if(type) %}/{{ type }}{% endif %}?lang={{ constant('LANG') }}" class="ui button">
            <i class="icon left arrow"></i> {{ helper.at('Wróć') }}
        </a>

        <div class="ui positive submit button">
            <i class="save icon"></i> {{ helper.at('Zapisz') }}
        </div>

        {% if model.getId() %}

        <a href="{{ url.get() }}publication/admin/delete/{{ model.getId() }}?lang={{ constant('LANG') }}" class="ui button red">
            <i class="icon trash"></i> {{ helper.at('Usuń') }}
        </a>

        {% if model.getId() %}
        <a class="ui blue button" target="_blank"
           href="{{ helper.langUrl(['for':'publication','type':model.getTypeSlug(), 'slug':model.getSlug()]) }}">
            {{ helper.at('Podgląd') }}
        </a>
        {% endif %}

        {% endif %}

    </div>
    <!--end controls-->
    <div class="ui segment">
        <div class="ui grid">
            <div class="twelve wide column">

                <input type="hidden" name="user_id" id="userId" value="{{ model.getUserId() }}">
                <input type="hidden" name="post_id" id="postId" value="{{ model.getId() }}">
            
                <input type="hidden" name="lang" value="{{ constant('LANG') }}">


                {{ form.renderDecorated('title') }}
                {{ form.renderDecorated('slug') }}

                {% if type !== 'dokumenty' and type !== 'encyklopedia' %}
                {{ form.renderDecorated('meta_title') }}
                {{ form.renderDecorated('meta_description') }}
                {{ form.renderDecorated('meta_keywords') }}
                  {% endif %}
                  
                 {% if type !== 'encyklopedia' and type !== 'dokumenty' %}
                {{ form.renderDecorated('excerpt') }}   
                 {% endif %}
                 
                 {% if type !== 'dokumenty' %}
                {{ form.renderDecorated('text') }}
                {% endif %}
              
            </div>
            <div class="four wide column">
                				
                {{ form.renderDecorated('type_id') }}
                
                <ul style="max-height: 500px; overflow: scroll">
                 {% if type !== 'encyklopedia' %}
                 {% for key,value in cats %}
                 <li>
                 <label for="category-{{key}}">{{value}}</label>
                 
                 <input {% if in_array(key, pubcats) %}checked="checked"{% endif %} type="checkbox" name="categories[{{key}}]" id="category-{{key}}">
                 </li>
                 {% endfor %}
                </ul>
                {##}
                {# form.renderDecorated('category_id') #}
                {% else %}
                <input type='hidden' name='category_id' value='0'>
                 {% endif %}
                {{ form.renderDecorated('status') }}
                {{ form.renderDecorated('date') }}
                {% if type !== 'dokumenty' and type != 'encyklopedia' %}
                {{ form.renderDecorated('preview_src') }}
                {{ form.renderDecorated('preview_inner') }}
                {{ form.renderDecorated('comments_enabled') }}
                {% endif %}
                 {% if type !== 'encyklopedia' %}
                {{ form.renderDecorated('paid_content') }}
                {% endif %}
                {{ form.renderDecorated('counter') }}
            </div>
        </div>
    </div>

</form>
<!--ui semantic-->
<script>
    $(".ui.form").form({
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

<link rel="stylesheet" href="{{ url.path() }}vendor/bootstrap/datetimepicker/bootstrap-datetimepicker.min.css">
<script src="{{ url.path() }}vendor/bootstrap/datetimepicker/moment.js"></script>
<script src="{{ url.path() }}vendor/bootstrap/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script>
    $('#date').datetimepicker({
        locale: 'en',
        format: 'YYYY-MM-DD HH:mm:ss',
        showClose: true
    });
</script>

{% if type === 'dokumenty' and !model.getId() %}
	Żeby dodać pliki wymagane jest najpierw wpisanie tytułu i zapisanie publikacji, gdyż można dodawać pliki tylko do istniejącej fizycznie publikacji.
{% endif %}
{% if model.getId() and type === 'dokumenty' %}
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="{{ url.get() }}vendor/jQuery-File-Upload-9.11/css/jquery.fileupload.css">
<link rel="stylesheet" href="{{ url.get() }}vendor/jQuery-File-Upload-9.11/css/jquery.fileupload-ui.css">
<div class="ui segment">
    <div class="ui grid">
        <div class="twelve wide column">

            <!-- The file upload form used as target for the file upload widget -->
            <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Dodaj pliki...</span>
                            <input type="file" name="files[]" multiple>
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Rozpocznij upload</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Anuluj upload</span>
                        </button>
                        <button type="button" class="btn btn-danger delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Usuń</span>
                        </button>
                        <input type="checkbox" class="toggle">
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div class="col-lg-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
            </form>
        </div>
    </div>
</div>

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {{ '{%' }} for (var i=0, file; file=o.files[i]; i++) { {{ '%}' }}
    <tr class="template-upload fade">
    <td class="title"><input placeholder="Tytuł" size="60" name="title[]" required></td>
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{{ "{%=" }} file.name {{ "%}" }}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td>
    {{ "{%" }} if (!i && !o.options.autoUpload) { {{ "%}" }}
    <button class="btn btn-primary start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
    </button>
    {{ "{%" }} } {{ "%}" }}
    {{ "{%" }} if (!i) { {{ "%}" }}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Anuluj</span>
    </button>
    {{ "{%" }}  }  {{ "%}" }}
    </td>
    </tr>

    {{ '{%' }} } {{ '%}' }}
</script>

<script id="template-download" type="text/x-tmpl">
    {{ "{%" }} for (var i=0, file; file=o.files[i]; i++) {  {{ "%}" }}
    <tr class="template-download fade">
                     <td class="title">{{'{%'}}=file.title{{'%}'}}<input style="display: none" placeholder="Tytuł" size="60" name="title[{{'{%'}}=file.id{{'%}'}}]" value="{{'{%'}}=file.title{{'%}'}}" required></td>
    <td>
    <span class="preview">
    {{ "{%" }} if (file.thumbnailUrl) { {{ "%}" }}
    <a href="{{'{%'}}=file.url{{'%}'}}" title="{{'{%'}}=file.name{{'%}'}}" download="{{'{%'}}=file.name{{'%}'}}" data-gallery><img src="{{'{%'}}=file.thumbnailUrl{{'%}'}}"></a>
    {{ "{%" }} } {{ "%}" }}
    </span>
    </td>
    <td>
    <p class="name">
    {{ "{%" }} if (file.url) { {{ "%}"}}
    <a href="{{'{%='}}file.urlpath{{'%}'}}" title="{{'{%='}}file.name{{'%}'}}" download="{{'{%='}}file.name{{'%}'}}" {{'{%='}}file.thumbnailUrl?'data-gallery':'' {{'%}'}}>{{'{%='}}file.name{{'%}'}}</a>
    {{ "{%"}} } else { {{ "%}"}}
    <span>{{ "{%="}}file.name{{ "%}"}}</span>
    {{ "{%"}} } {{ "%}"}}
    </p>
    {{ "{%"}} if (file.error) { {{ "%}"}}
    <div><span class="label label-danger">Error</span> {{"{%="}}file.error{{"%}"}}</div>
    {{ " {%"}} } {{ "%}"}}
    </td>
    <td>
    <span class="size">{{ "{%="}}o.formatFileSize(file.size){{ "%}"}}</span>
    </td>
    <td>
    {{ "{% if (false && file.updateUrl) { %}"}}
        <button class="btn btn-primary update" data-type="{{'{%='}}file.dataType{{'%}'}}" data-url="{{'{%='}}file.updateUrl{{'%}'}}" {{"{%"}} if (file.deleteWithCredentials) { {{ "%}" }} data-xhr-fields='{"withCredentials":true}' {{ "{%"}} } {{"%}" }}>
    <i class="glyphicon glyphicon-edit"></i>
    <span>Aktualizuj</span>
    </button>      
      {{ "{% } %}"}}
    {{ "{% if (file.deleteUrl) { %}"}}
    <button class="btn btn-danger delete" data-type="{{'{%='}}file.deleteType{{'%}'}}" data-url="{{'{%='}}file.deleteUrl{{'%}'}}" {{"{%"}} if (file.deleteWithCredentials) { {{ "%}" }} data-xhr-fields='{"withCredentials":true}' {{ "{%"}} } {{"%}" }}>
    <i class="glyphicon glyphicon-trash"></i>
    <span>Usuń</span>
    </button>
    <input type="checkbox" name="delete" value="1" class="toggle">
             
    {{ "{% } else { %}"}}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Anuluj</span>
    </button>
    {{ "{% } %}"}}
    </td>
    </tr>
    {{ "{% } %}"}}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="{{ url.get() }}vendor/jQuery-File-Upload-9.11/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

{% endif %}
<script type="text/javascript" src="{{ url.get() }}vendor/tiny_mce_3/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        selector: "#excerpt",
        language: "en", // "ru"
        height: "300px",
        theme: "advanced",
        plugins: "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1: ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,charmap,iespell,media,advhr,",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,fullscreen",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        theme_advanced_blockformats: "p,h1,h2,h3,h4",
        theme_advanced_font_sizes: "9px,10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px",
        browser_spellcheck: true,
        relative_urls: false,
        convert_urls: true,
        element_format: "html5",
        file_browser_callback: 'elFinderBrowser_3',
        // Skin options
        skin: "o2k7",
        skin_variant: "silver",
        extended_valid_elements: "a[href|target=_blank]",
        // Example content CSS (should be your site CSS)
        content_css: "{{ url.get() }}static/css/tinymce.css"
    });
    tinyMCE.init({
        // General options
        selector: "#text",
        language: "en", // "ru"
        height: "500px",
        theme: "advanced",
        plugins: "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1: ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor",
        theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,charmap,iespell,media,advhr,",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,fullscreen",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        theme_advanced_blockformats: "p,h1,h2,h3,h4",
        theme_advanced_font_sizes: "9px,10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px",
        browser_spellcheck: true,
        relative_urls: false,
        convert_urls: true,
        element_format: "html5",
        file_browser_callback: 'elFinderBrowser_3',
        // Skin options
        skin: "o2k7",
        skin_variant: "silver",
        extended_valid_elements: "a[href|target=_blank]",
        // Example content CSS (should be your site CSS)
        content_css: "{{ url.get() }}static/css/tinymce.css"
    });
</script>
