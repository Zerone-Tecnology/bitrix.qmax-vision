$(document).ready(function(){
        $('body').on('click', '.j_menulink', function () {
            $(this).toggleClass('selected');
            if ($(this).siblings('.j_menusub').length) {
                $(this).siblings('.j_menusub').slideToggle();
                return false;
            }
        });


        $('body').on('click', '.j_show_hide_menu, .j_close_hide_menu', function () {
            var th = $('.i_lblock');
            var left = th.css('left');
            if (left == '-270px') {
                closeall();
                th.animate({left: 0}, 300);
            }
            else {
                th.animate({left: -270}, 300);
            }

        });

        $(window).resize(function(){
            if( $(window).width<640 ) {
                $('.j_mo_ad').bind('click', navMoAd);
            }
        });

        function closeall() {
            $('.i_lblock').animate({left: -270}, 300);
        }

        $('body').on('click', '.jq_hp_auth_personal', function () {
            $(this).siblings('.i_modal').fadeToggle();
            //i_close('#jq_fp_auth_personal');
            // i_hide();
            return false;
        });

        // Скроллинг
        jQuery('.j_lmenu_scrollbar').scrollbar();

        // Показ кнопки
	    $('.j_show_hide_menu').show();
});
