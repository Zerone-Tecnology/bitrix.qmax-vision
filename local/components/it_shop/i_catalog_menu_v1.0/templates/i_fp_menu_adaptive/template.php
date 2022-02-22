<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	// Frame
	$frame = $this->createFrame('jq_fp_vmenu', false)->begin();
	//CVariablesStorage::set('TypeMenu', 'vertical');
		$frame->setAnimation(true);?>
    <div class="i_v_menu_title i_fp_menu_title j_fp_v_menu_title">
        <div style="display: inline-block"><span>Каталог </span><span class="tov">товаров</span></div>
    </div>

    <div class="i_fp_menu_mobile_title i_v_menu_title i_fp_menu_title j_fp_v_menu_mobile_title">
        <div style="display: inline-block"><span>Каталог </span><span class="tov">товаров</span></div>
    </div>

    <div class="i_foot_catalog_menu j_catalog_menu_scrollbar idnone">
		<?/*<div class="i_fp_cat_title j_fp_cat_title">
            <span>Каталог товаров</span>
            <span class="i_modal_close j_cm_close ipabs"></span>
        </div>*/?>
        <div class="i_v_menu_foot j_cm_col iprel idnone">
            <div class="i_v_menu_content j_cm_col j_scrollbar scrollbar-inner">
				<? $k = 0; foreach($arResult['ITEMS'] as $key=>$arItem): ?>
                    <div class="i_v_menu_div_1 ">
                        <a class="i_v_menu_link_1<?if($arItem['I_CHILD']) echo ' jq_fp_v_submenu';?>" href="<?=$arItem['SECTION_PAGE_URL'];?>" data-level="1" data-id="<?=$key?>">
							<?=$arItem['NAME']?>
                        </a>
                    </div>
				<? endforeach; ?>
            </div>
            <div class="i_v_menu_sub j_cm_col idnone">
				<? foreach($arResult['ITEMS'] as $key=>$arItem): ?>
                    <div class="i_v_menu_sub_wrap idnone" data-id="<?=$key?>">
                        <div class="i_v_menu_sub_cont<?if($arItem['I_PRODUCT']) echo ' i_product_item'; if($arItem['UF_COLUM_MENU']) echo ' col_'.$arItem['UF_COLUM_MENU'];?> j_cm_col j_scrollbar scrollbar-inner" style="
                                -moz-column-count: <?=$arItem['UF_COLUM_MENU'];?>;
                                -webkit-column-count: <?=$arItem['UF_COLUM_MENU'];?>;
                                column-count: <?=$arItem['UF_COLUM_MENU'];?>;" >
							<?/*<div class="j_scrollbar scrollbar-inner">*/?>
							<? foreach($arItem['I_CHILD'] as $arItem2): ?>
                                <div class="i_v_menu_div_2">
                                    <a href="<?=$arItem2['SECTION_PAGE_URL']?>" class="i_v_menu_link_2"><?=$arItem2['NAME']?></a>
									<? foreach($arItem2['I_CHILD'] as $arItem3): ?>
                                        <div class="i_v_menu_div_3">
                                            <a href="<?=$arItem3['SECTION_PAGE_URL']?>" class="i_v_menu_link_3"><?=$arItem3['NAME']?></a>
											<? foreach($arItem3['I_CHILD'] as $arItem4): ?>
                                                <div class="i_v_menu_div_4">
                                                    <a href="<?=$arItem4['SECTION_PAGE_URL']?>" class="i_v_menu_link_4"><?=$arItem4['NAME']?></a>
                                                </div>
											<? endforeach; ?>
                                        </div>
									<? endforeach; ?>
                                </div>
							<? endforeach; ?>
							<?/*if($arItem['I_PRODUCT']):?>
                                    <div class="i_v_menu_sub_item">
                                        <? i_showItem($APPLICATION, array('FROM'=>'MENU'), $arResult['I_PRODUCT'][$arItem['I_PRODUCT']], $arParams); ?>
                                    </div>
                                <?endif;*/?>
							<?if($arItem['UF_COLUM_MENU'] >= 4):?>
                                <div class="i_v_menu_sub_vert_line"></div>
							<?endif;?>
							<?/*</div>*/?>
                        </div>
                    </div>
				<? endforeach; ?>
            </div>
        </div>
        <div class="i_v_menu_mobile i_v_menu_mobile_foot j_cm_col idnone">
            <div class="i_v_menu_mobile_content j_scrollbar scrollbar-inner">
				<? $k = 0; foreach($arResult['ITEMS'] as $arItem): ?>
                    <div class="i_v_menu_mobile_div_1">
                        <a class="i_v_menu_mobile_link_1<?if($arItem['I_CHILD']) echo ' j_fp_v_menu_mobile_link';?>" href="<?=$arItem['SECTION_PAGE_URL']?>" data-id="<?=$arItem['ID']?>">
                            <span><?=$arItem['NAME']?></span></a>
						<? if($arItem['I_CHILD']): ?>
                            <div class="i_v_menu_mobile_sub" data-id="<?=$arItem['ID']?>">
								<? foreach($arItem['I_CHILD'] as $arItem2): ?>
                                    <a href="<?=$arItem2['SECTION_PAGE_URL']?>" class="i_v_menu_mobile_link_2<?if($arItem2['I_CHILD']) echo ' j_fp_v_menu_mobile_link';?>" data-id="<?=$arItem2['ID']?>">
                                        <span><?=$arItem2['NAME']?></span></a>
									<? if($arItem2['I_CHILD']): ?>
                                        <div class="i_v_menu_mobile_sub" data-id="<?=$arItem2['ID']?>">
											<? foreach($arItem2['I_CHILD'] as $arItem3): ?>
                                                <a class="i_v_menu_mobile_link_3<?if($arItem3['I_CHILD']) echo ' j_fp_v_menu_mobile_link';?>" href="<?=$arItem3['SECTION_PAGE_URL']?>" data-id="<?=$arItem3['ID']?>">
                                                    <span><?=$arItem3['NAME']?></span></a>
												<? if($arItem3['I_CHILD']): ?>
                                                    <div class="i_v_menu_mobile_sub" data-id="<?=$arItem3['ID']?>">
														<? foreach($arItem3['I_CHILD'] as $arItem4): ?>
                                                            <a class="i_v_menu_mobile_link_4" href="<?=$arItem4['SECTION_PAGE_URL']?>"><span><?=$arItem4['NAME'];?></span></a>
														<? endforeach; ?>
                                                    </div>
												<? endif; ?>

											<? endforeach; ?>
                                        </div>
									<? endif; ?>
								<? endforeach; ?>
                            </div>
						<? endif; ?>
                    </div>
				<? endforeach; ?>
            </div>
        </div>
    </div>
	<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>
	<?
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>

<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arResult);?></pre>
<?endif*/?>
