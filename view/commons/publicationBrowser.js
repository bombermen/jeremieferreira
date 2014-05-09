var fullHeight = 230;
var minHeight = 200;
var maxHeight = 0;

$(document).ready(function(){
    $(".publicationThumb img").css("height", minHeight + "px");
    
    $(".publicationThumb").filter(function() {
        
        var img = $(this).find("img");
        var ratio = img.width() / img.height();
        var newHeight = fullHeight * ratio;
        $(this).css("width", newHeight);
        
        if(newHeight > maxHeight)
            maxHeight = newHeight;
    });
    
    $(".publicationThumb").css("height", (maxHeight) + "px")
});

$(".publicationThumb").mouseover(function(){
    $(".page").css("background", "#EDF");
    $(".publicationThumb").css("color", "#EDF");
    $(this).find("img").css("height", fullHeight + "px");
});

$(".publicationThumb").mouseout(function(){
    $(".page").css("background", "#FFF");
    $(".publicationThumb").css("color", "#FFF");
    $(this).find("img").css("height", minHeight + "px");
});