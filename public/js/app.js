
/* Configuration */

window.app = {
    csrf_token : $('meta[name="csrf-token"]').attr('content')
};



$(document).ready(function()
{

    /*
     *  Navigation Toggle
     */

    $('.btn-nav-toggle').click(function()
    {
        $('#navigation').addClass('is-open');
        $('#cover').fadeIn();
    });

    $('#cover').click(function()
    {
        $('#navigation').removeClass('is-open');
        $(this).fadeOut();
    });

});