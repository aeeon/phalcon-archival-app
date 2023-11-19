$(document).ready(function()
{
    $('#main-menu ul').css('height', $('#header-nav').height() + "px");
    
    
    $('#main-menu-ul li').mouseenter(function()
    {
        if(!$(this).hasClass('active')) { $('img', this).attr('src', $('img', this).attr('src').replace('.png', '-hover.png')); }
    });
    
    $('#main-menu-ul li').mouseleave(function()
    {
        if(!$(this).hasClass('active')) { $('img', this).attr('src', $('img', this).attr('src').replace('-hover.png', '.png')); }
    });
    
    
    $('#main-menu-ul').click(function()
    {
        location.href = $('a', this).attr('href');
    });
    
    
    $('.dropdown').css('width', $('#site-main').width() + "px");
    
    
    
    $('#show-menu').click(function()
    {
        $('.mobile-menu').slideToggle('fast');
        $(this).toggleClass('close');
    });

    
    
    
     $('#menu-item-1').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        if ($('#dropdown-menu-item-1').css('display') == 'none') {
            $('#dropdown-menu-item-1').slideDown('slow');
        }
    });

    $('#menu-item-2').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        if ($('#dropdown-menu-item-2').css('display') == 'none') {
            $('#dropdown-menu-item-2').slideDown('slow');
        }
    });

    $('#menu-item-3').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        if ($('#dropdown-menu-item-3').css('display') == 'none') {
            $('#dropdown-menu-item-3').slideDown('slow');
        }
    });

    $('#menu-item-4').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        if ($('#dropdown-menu-item-4').css('display') == 'none') {
            $('#dropdown-menu-item-4').slideDown('slow');
        }
    });
    $('#menu-item-5').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        //if($('#dropdown-menu-item-4').css('display') == 'none') { $('#dropdown-menu-item-4').slideDown('slow'); }
    });
    $('#menu-item-6').mouseenter(function ()
    {
        $('.dropdown').slideUp('fast');
        // if($('#dropdown-menu-item-4').css('display') == 'none') { $('#dropdown-menu-item-4').slideDown('slow'); }
    }); 
     
    
    
    
    
    $('.left-nav ul li a.menu-second-level').mouseenter(function()
    {
        $('.submenu').hide();
        $('#' + $(this).attr('id').replace('a', 'box')).show();
        
        //return false;
    });
    
    $('#site-main').mouseleave(function()
    {
        $('.dropdown').slideUp('fast');
    });
});