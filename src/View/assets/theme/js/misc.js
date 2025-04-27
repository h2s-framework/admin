(function ($) {
    'use strict';
    $(function () {
        let body = $('body');
        let sidebar = $('.sidebar');


        let baseUrl = $('base').attr('href');
        let currentUrl = location.href.replace(/\/+$/g, '');
        function addActiveClass(element) {
            let url = URL.parse(element.attr('href'), baseUrl);
            if(url.href.endsWith('#') && url.hash.length === 0){ return; }

            if ( url.href.replace(/\/+$/g, '') === currentUrl ) {
                element.parents('.nav-item').last().addClass('active');
                if (element.parents('.sub-menu').length) {
                    element.closest('.collapse').addClass('show');
                    element.addClass('active');
                }
                if (element.parents('.submenu-item').length) {
                    element.addClass('active');
                }
            }
        }


        $('.nav li a', sidebar).each(function () {
            addActiveClass($(this));
        })

        //Close other submenu in sidebar on opening any

        sidebar.on('show.bs.collapse', '.collapse', function () {
            sidebar.find('.collapse.show').collapse('hide');
        });


        //Change sidebar and content-wrapper height
        applyStyles();

        function applyStyles() {
            //Applying perfect scrollbar
            if (!body.hasClass("rtl")) {
                if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
                    new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
                }
                if (body.hasClass("sidebar-fixed")) {
                    new PerfectScrollbar('#sidebar .nav');
                }
            }
        }

        $('[data-toggle="minimize"]').on("click", function () {
            if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
                body.toggleClass('sidebar-hidden');
            } else {
                body.toggleClass('sidebar-icon-only');
            }
        });

    });
})(jQuery);