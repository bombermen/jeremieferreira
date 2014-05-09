$("#main_menu_button").on("click", function() {
    var elt = $("#lateral_menu");
    var top_menu = $("#top_menu");
    var width = elt.width();

    if (elt.hasClass("deployed")) {
        elt.css("left", -width + "px");
        elt.removeClass("deployed");
        top_menu.css("left", "0px");
    } else {
        elt.css("left", "0px");
        elt.addClass("deployed");
        top_menu.css("left", width + "px");
    }
});