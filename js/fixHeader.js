const fixHeaderPadding = (function () {
    $('body').css('padding-top', parseInt($('#main-navbar').css("height"))+10);
});

$(window).on('resize', fixHeaderPadding);
$(window).on('load', fixHeaderPadding);