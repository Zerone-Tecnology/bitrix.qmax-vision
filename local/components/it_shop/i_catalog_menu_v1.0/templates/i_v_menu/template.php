<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	// Frame
	$frame = $this->createFrame('jq_vmenu', false)->begin();
//	$frame->setAnimation(true);?>

	<?function i_v_view_cat($data, $product, $arParams, $arOption)
	{
		foreach ($data as $menu):
			$DL = $menu['DEPTH_LEVEL']?>

			<div class="i_vmenu_div_<?=$DL?> jq_vmenu_div_<?echo $DL;if( $arOption['POS'] == 'Y') echo ' iprel'?>">

				<a href="<?=$menu['SECTION_PAGE_URL']?>" class="i_vmenu_a_<?=$DL;if($DL==1 && $menu['I_CHILD'])echo ' i_vmenu_arrow jq_vmenu_arrow';if($menu['I_SELECTED'])echo ' i_vmac_'.$menu['DEPTH_LEVEL']?>">
					<?echo $menu['NAME'];if( ($DL==1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$menu['ELEMENT_CNT'].')'?>
				</a>

				<?if($menu['I_CHILD']):?>
					<div class="i_col_<?=$arParams['I_COUNT_COL']?> <?if($menu['I_PRODUCT']) echo 'i_vsub_item ';?>i_vsub_<?=$DL?> jq_vsub_<?=$DL;if($DL==1)echo ' ivhid'?>"<?/*if( $menu['UF_COLUM_MENU'] )echo ' jq_vm_col="'.$menu['UF_COLUM_MENU'].'" style="width:'.$menu['I_COLUM_WIDTH'].'px"'*/?>>
						<?if($menu['I_PRODUCT'])
							echo '<div class="i_vmline ipabs"></div>'?>
						<?if($DL==1)echo '<div class="jq_ver_shapeshift iprel" data-col="'.$arParams['I_COUNT_COL'].'">'?>
						<?if($menu['I_PRODUCT'])
							i_showItem($APPLICATION, array('FROM'=>'MENU'), $product[$menu['I_PRODUCT']], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php

							i_v_view_cat($menu['I_CHILD'], $arParams, array());

						if($DL==1)echo '</div>'?>
					</div>
				<?endif?>

			</div>
		<?endforeach;
	}?>

<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>

	<?if( $arParams['I_MENU_EXTENSION'] == 'Y' ):?>
		<nav class="ic_vmenu iprel jq_vmenu i_heauto">
			<div class="i_vmenu_catalog iprel ifont110"><?=GetMessage('CATALOG')?></div>
			<div class="i_vmenu_out jq_vmenu_out iprel i_heauto">
				<div class="i_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arResult['I_PRODUCT'], $arParams, array('POS'=>'N') )?>
				</div>
			</div>
		</nav>
	<?elseif( !CSite::InDir(SITE_DIR.'index.php') && $arParams['I_HIDE_MENU'] == 'Y' ):?>
		<nav class="ic_vmenu jq_vmenu iprel">
			<div class="i_vmenu_catalog jqc_vmenu_catalog iprel ifont110 ibr5i"><span class="i_vmenu_carrb jq_vmenu_catarr"><?=GetMessage('CATALOG')?></span></div>
			<div class="ic_vmenu_out jqc_vmenu_out ipabs ivhid">
				<div class="ic_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arResult['I_PRODUCT'], $arParams, array('POS'=>'Y') )?>
				</div>
			</div>
		</nav>
	<?else:?>
		<nav class="i_vmenu jq_vmenu iprel">
			<div class="i_vmenu_catalog jq_vmenu_catalog iprel ifont110"><span class="i_vmenu_carrb jq_vmenu_catarr"><?=GetMessage('CATALOG')?></span></div>
			<div class="i_vmenu_out jq_vmenu_out iprel iohidden">
				<div class="i_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arResult['I_PRODUCT'], $arParams, array('POS'=>'N') )?>
					<div class="i_vmenu_empty"></div>
					<div class="i_vmenu_div_1 i_buttom_vmenu jq_buttom_vmenu ipabs"></div>
				</div>
			</div>
		</nav>
	<?endif?>


	<div class="i_vmenu_mobi idnone jq_h_menu_mobi"><?=GetMessage('CATALOG_TITLE');?></div>
	<div class="i_vmenu_cmapodmenu  jq_cmapodmenu idnone">
		<?foreach($arResult['ITEMS'] as $e):?>
			<div class="i_vmenu_cmaitem1">
				<a href="<?=$e['SECTION_PAGE_URL']?>" class="i_vmenu_cmalink jq_i_cmalink ifont130 iprel">
					<?=$e['NAME']?>
					<?
					if($e[$arParams['I_MOBILE_ICON']]) $img = $e[$arParams['I_MOBILE_ICON']];
					else $img = $e['~PICTURE'];
					?>
					<div class="i_cmaicon1_wrap ipabs" style="background-image: url('<?=$img;?>')"></div>
					<?if(!empty($e['I_CHILD'])):?>
						<span class="i_cmastr ipabs i_cmastrr"></span>
					<?endif?>
				</a>
				<?if(!empty($e['I_CHILD'])):?>
					<div class="i_vmenu_cmapod j_cmapod i_cmaopen0 idnone">
						<?foreach($e['I_CHILD'] as $arSubItem):?>
							<a href="<?=$arSubItem['SECTION_PAGE_URL']?>" class="i_vmenu_cmalink2 iprel" rel="1"><?=$arSubItem['NAME']?></a>
						<?endforeach?>
					</div>
				<?endif?>
			</div>
		<?endforeach;?>
	</div>

<?

/*

			<div>
				<div class="i_vmenu_out jq_vmenu_out ipabs">
					<div class="i_vmenu_in jq_vmenu_in">
						<?i_view_cat( $arResult['ITEMS'], $arParams, array('POS'=>'N') )?>
					</div>
				</div>
				<div class="i_vmenu_div_1 i_buttom_vmenu jq_buttom_vmenu"></div>
			</div>

*/

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>