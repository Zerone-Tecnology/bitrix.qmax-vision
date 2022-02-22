$(document).ready(function(){

    $('body').on('click', '.j_fp_v_menu_mobile_link', function() {
        $(this).toggleClass('checked');
        var submenu = $('.i_v_menu_mobile_sub[data-id='+$(this).data('id')+']');
        submenu.slideToggle();
        return false;
    });
    $('body').on('click', '.jq_fp_v_submenu', function() {
        $('.i_v_menu_sub_wrap').not($(this).siblings('.i_v_menu_sub_wrap')).hide();
        $(this).siblings('.i_v_menu_sub_wrap').fadeToggle();
        $('.jq_fp_v_submenu').removeClass('select');
        $(this).toggleClass('select');
        return false;
    });

    $('body').on('click','.j_fp_v_menu_title',function() {
        $(this).siblings('.i_foot_catalog_menu').toggleClass('visible');
        $(this).siblings('.i_foot_catalog_menu').find('.i_v_menu_content').toggleClass('visible');
        $(this).toggleClass('visible');
        $('.i_v_menu_sub').css('display', 'none');
    });

    $('body').on('click','.j_fp_v_menu_mobile_title',function() {
        $(this).siblings('.i_foot_catalog_menu').toggleClass('visible');
        $(this).siblings('.i_foot_catalog_menu').find('.i_v_menu_mobile_content').toggleClass('visible');
        $(this).siblings('.i_foot_catalog_menu').find('.i_v_menu_mobile').toggleClass('visible');
        $(this).toggleClass('visible');
    });

    $('body').on('click','.j_cm_close',function() {
        var i_fp_menu = $('.i_foot_catalog_menu');
        i_fp_menu.removeClass('visible');
        i_fp_menu.find('.i_v_menu_content').removeClass('visible');
        i_fp_menu.find('.i_v_menu_mobile_content').removeClass('visible');
        i_fp_menu.find('.i_v_menu_mobile').removeClass('visible');
        i_fp_menu.find('.j_fp_v_menu_title').removeClass('visible');
    });

    $('.j_scrollbar').scrollbar({
        'disableBodyScroll': true,
        'showArrows': true
    });

    var heightWindow = $(window).height();

    if(heightWindow >= 720)
    {
        $('.j_cm_col').css('height','640px');
        $('.i_foot_catalog_menu').css('height','720px');
    }
    else if(heightWindow < 720)
    {
        $('.j_cm_col').height(heightWindow-110);
        $('.i_foot_catalog_menu').css('height',heightWindow-60);
    }

    $('body').on('click','.jq_fp_v_submenu',function(){
        var id = $(this).data('id');
        //var level = $(this).data('level');
        var nextlevel = $('.i_v_menu_sub_wrap[data-id='+id+']');
        var heightWindow = $(window).height() - 100;

        $('.i_v_menu_sub').hide();
        $('.i_v_menu_sub_wrap').hide();
        $('.i_v_menu_sub').fadeIn(400);
        nextlevel.fadeIn(400);
        return false;
    });

});
