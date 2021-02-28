$(function() {
    $(".search-input").keydown(function(e) {
        if (e.keyCode == 13) {
            $(this)
                .parents("form")
                .submit();
        }
    });
});
