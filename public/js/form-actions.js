(function($) {
    


    
})(window);

jQuery(function($) {
    $(".entity-actions-enter")
    .on("click", function() {
        $(this).parents('.entity-actions').find(".entity-actions-enter").hide();
        $(this).parents('.entity-actions').find(".entity-actions-group").show();
    });
    $(".entity-actions").on('mouseleave', function(o) {
        $(this).find(".entity-actions-group").hide();
        $(this).find(".entity-actions-enter").show();
    });
});