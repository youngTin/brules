/*jslint browser: true, sloppy: true, vars: true, white: true, maxerr: 50, indent: 4 */
/*global $*/

function initSideMenu() {
    var win = $(window),
      sidebar = $('#main-sidebar'),
      sidebarTop = sidebar.offset().top,
      sidebarHeight = sidebar.height(),
      footerPos = $('.footer-block').offset().top;

    if (sidebarHeight < $('.main-content-block').height()) {
        win.scroll(function () {
            var scrollTop = win.scrollTop();
            if (scrollTop > sidebarTop) {
                if (scrollTop + sidebarHeight < footerPos) {
                    sidebar.addClass('scrolled').removeClass('fixedbottom');
                } else {
                    sidebar.removeClass('scrolled').addClass('fixedbottom');
                }
            } else {
                sidebar.removeClass('scrolled');
            }
        });
    }
}

$(function () {
    $('#btn-back-top').click(function (e) {
        $('body,html,document').animate({ scrollTop: $(this).position().top }, 400);
        e.preventDefault(e);
    });

    if ($().lightBox) {
        $('a[rel*=lightbox]').lightBox();
    }
});
