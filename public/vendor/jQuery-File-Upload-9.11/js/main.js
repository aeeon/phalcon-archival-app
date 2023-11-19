/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';
    var id = $("#postId").val();
    var userid = $("#userId").val();
    var postData = {id: id, userid: userid};
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        //url: 'http://jakprawnie.local/vendor/jQuery-File-Upload-9.11/server/php/'//
        url: '/publication/admin/upload/' + id,
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                    )
            );

    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
        var inputs = data.context.find(':input');
        if (inputs.filter(function () {
            return !this.value && $(this).prop('required');
        }).first().focus().length) {
            data.context.find('button').prop('disabled', false);
            return false;
        }
        data.formData = inputs.serializeArray();
    });
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
    });


});
