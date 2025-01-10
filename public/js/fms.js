$(document).ready(function () {
    $(".btn-mobile-nav").click(function () {
        $("body").toggleClass("mobile-nav-open");
    });

    $(".btn-mobile-sidepanel").click(function () {
        $("body").toggleClass("mobile-sidepanel-open");
    });

    checkAdressSticky();
});

$(".print-btn").click(function (ev) {
    ev.preventDefault();

    print();
});

$(".rights-link").magnificPopup({
    type: "ajax",
});

$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    var $nav = $(".sticky-wrapper");
    var height = $(window).height();
    var navBreakpoint = 76;
    if (scroll > navBreakpoint) {
        $nav.addClass("sticky");
    } else {
        $nav.removeClass("sticky");
    }

    var addressInfo = $(".address-info");
    if (!addressInfo.hasClass("always-sticky")) {
        var addressBreakpoint = 720 - height + Math.ceil((700 - height) * 0.5);
        if (scroll > addressBreakpoint) {
            addressInfo.addClass("sticky-address");
        } else {
            addressInfo.removeClass("sticky-address");
        }
    }
});

$(window).resize(function () {
    var width = $(window).width();
    var body = $("body");

    if (width <= 768) {
        if (width < 500) {
            body.removeClass("on-tablet");
            body.addClass("on-mobile");
        } else {
            body.removeClass("on-mobile");
            body.addClass("on-tablet");
        }
    } else {
        body.removeClass("on-mobile");
        body.removeClass("on-tablet");
    }

    checkAdressSticky();
});

window.checkAdressSticky = function () {
    var height = $(window).height();
    var stickyNavHeight = $(".sticky-wrapper .nav-sidebar").height();
    var addressInfo = $(".address-info");
    if (height > 710 || (height > 500 && stickyNavHeight < 400)) {
        addressInfo.addClass("sticky-address");
        addressInfo.addClass("always-sticky");
    } else {
        addressInfo.removeClass("sticky-address");
        addressInfo.removeClass("always-sticky");
    }
};

window.updateHeights = function (animate) {
    var shouldAnimate = animate === undefined ? false : animate;
    var sidebar = $(".sidebar");
    var content = $(".content-body");
    var sidepanel = $(".sidepanel");

    sidebar.removeAttr("style");
    content.removeAttr("style");
    sidepanel.removeAttr("style");

    var height = Math.max(
        sidebar.height(),
        content.height(),
        sidepanel.height()
    );

    if (shouldAnimate) {
        var animateHeight = function (elem) {
            elem.animate({ height: height });
        };

        animateHeight(sidebar);
        animateHeight(content);
        animateHeight(sidepanel);

        return;
    }

    sidebar.css("height", height);
    content.css("height", height);
    sidepanel.css("height", height);
};

window.getChartHeight = function (numBars) {
    var desiredHeight = 23;
    var margins = 20;
    var size = desiredHeight * numBars + (margins + 26 * 3); // label and legend. ((32 * 3) + 2)
    return size;
};

window.ChartNewJsWorkaround = function (selector, idName, width, height) {
    var canvas = $(document.createElement("canvas"));
    canvas.attr("width", width).attr("height", height);
    canvas.attr("id", idName);
    $(selector).children("canvas").replaceWith(canvas);
};

window.ChartNewJsAppend = function (selector, idName, width, height) {
    var canvas = $(document.createElement("canvas"));
    canvas.attr("width", width).attr("height", height);
    canvas.attr("id", idName);
    $(selector).append(canvas);
};

window.STUB = function (what) {
    alert("STUB: Not yet implemented:\n" + what);
};
