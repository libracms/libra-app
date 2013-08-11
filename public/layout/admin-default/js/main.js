/*
 * Main javascript file for admin-default layout
 */

//make dropdown menu open by mouseover
jQuery(function($) {
    $('ul.nav > li').mouseover(function() {
        $('ul.nav li.dropdown.open').removeClass('open');
    });
    $('li.dropdown').mouseover(function(o) {
        $(this).addClass('open');
    });
});
