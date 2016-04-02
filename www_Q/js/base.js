// JavaScript Document
function CalcMeasure() {
    var wH = $(window).height();
    var wW = $(window).width();
    $(".cbp-scroller-main >section").attr("style", "min-height:" + wH + "px;height:" + wH + "px;");
    $("#intro").attr("style", "min-height:" + wH + "px;height:" + wH + "px;");
    if (wW < 767) {
        wH = wH - 64;
        wW = wW - 64;
        $("#intro").attr("style", "min-height:" + wH + "px;height:" + wH + "px;");
    }
};
CalcMeasure();

function onePager(offsetMain, offsetIntro) {
    $('#nav').onePageNav({
        currentClass: "active",
        scrollOffset: offsetMain,
    });
    $("scroll-down button").click(function () {
        $('html, body').animate({
            scrollTop: $(".").offset().top - offsetMain
        }, 700);
    });
    $(window).scroll(function () {

        var windowTop = Math.max($('body').scrollTop(), $('html').scrollTop());
        if (windowTop > ($(window).height() - offsetIntro)) {
            $('header>nav').removeClass("ms-nav-anim");
        } else {
            $('header>nav').addClass("ms-nav-anim");
        }
    }).scroll();
}
if ($(window).width() < 767) {

    onePager(64, 84);
} else {
    onePager(100, 120);
    $('#intro').parallax("50%", 0.1);
    $('#portfolio').parallax("50%", 0.1);

    new cbpScroller(document.getElementById('cbp-so-scroller'));
}
window.addEventListener('resize', function (event) {
    CalcMeasure();
});
$(window).load(function (e) {
    $(".cover-all").remove();
});

var totalHeight = $(window).height();
$(".navbar-ex1-collapse").css("height", totalHeight + "px");
$(".navbar-ex1-collapse").css("max-height", totalHeight + "px");
window.addEventListener("resize", function () {
    if ($(window).width() < 767) {
        onePager(64, 84);
    } else {
        onePager(100, 120);
    }
    var totalHeight = $(window).height();
    $(".navbar-ex1-collapse").css("height", totalHeight + "px");
    $(".navbar-ex1-collapse").css("max-height", totalHeight + "px");
}, false);
/*---push menu----*/
$(".toggle-big-left").click(function (e) {
    if ($("#cbp-so-scroller").hasClass("outer-push") == true) {
        $("#cbp-so-scroller").removeClass("outer-push");
        $(".navbar-default").removeClass("visible");
    } else {
        $("#cbp-so-scroller").addClass("outer-push");
        $(".navbar-default").addClass("visible");
    }
});
$('.carousel').carousel({
    interval: 5000
})
if ($("html").hasClass("no-touch") == true) {
    $('#intro').parallax("50%", 0.1);
    $('#portfolio').parallax("50%", 0.1);

    new cbpScroller(document.getElementById('cbp-so-scroller'));
}