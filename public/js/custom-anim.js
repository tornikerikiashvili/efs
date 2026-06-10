function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function addClassWhenScreen(whenseethisclass,addthisclass){
    var elm = $('.'+whenseethisclass);

    if(elm.length){
        if (isScrolledIntoView(elm) === true) {
            if(!$( "#mydiv" ).hasClass(addthisclass)){
                $(elm).addClass(addthisclass).css({opacity: 1 });
            }
        }
    }
    
}