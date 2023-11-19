$(document).ready(function()
{
    $('.category-box a').click(function()
    {
        $('.category-box a').removeClass('active');
        $('.category-box ul').slideUp('fast');
        
        if($('#' + $(this).attr('id').replace('a-', 'box-')).css('display') == 'none') 
        { 
            $('#' + $(this).attr('id').replace('a-', 'box-')).slideDown('slow'); 
            $(this).addClass('active');
        }
        
        return false;
    });
});