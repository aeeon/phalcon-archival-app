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
    
    $('.dropdown').css('width', $('#site-main').width() + "px");
    
    
    
    $('#show-menu').click(function()
    {
        $('.mobile-menu').slideToggle('fast');
        $(this).toggleClass('close');
    });
    
    
    
    //$('#a-prawo-dla-kazdego').click(function()
    $('#a-prawo-dla-kazdego').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
        if($('#dropdown-prawo-dla-kazdego').css('display') == 'none') { $('#dropdown-prawo-dla-kazdego').slideDown('slow'); }
        
        //return false;
    });
    
    $('#a-prawo-dla-firm').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
        if($('#dropdown-prawo-dla-firm').css('display') == 'none') { $('#dropdown-prawo-dla-firm').slideDown('slow'); }
        
        //return false;
    });
    
    $('#a-wzory-pism').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
        if($('#dropdown-wzory-pism').css('display') == 'none') { $('#dropdown-wzory-pism').slideDown('slow'); }
        
        //return false;
    });
    
    $('#a-oferta').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
        if($('#dropdown-oferta').css('display') == 'none') { $('#dropdown-oferta').slideDown('slow'); }
        
        //return false;
    });
    
    $('#a-encyklopedia-prawa').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
    });
    
    $('#a-encyklopedia-prawna').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
    });
    
    $('#a-kontakt').mouseenter(function()
    {
        $('.dropdown').slideUp('fast');
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