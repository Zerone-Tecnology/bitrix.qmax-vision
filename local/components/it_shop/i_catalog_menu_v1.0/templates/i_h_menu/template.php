<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
$co		= count($arResult['ITEMS']);
$w		= floor( 940/$co );
$l_w	= ($w+940)-( $w*$co );
$frame	= $this->createFrame('jq_hmenu', false)->begin();

function i_h_view_cat($data, $product, array $arParams = array(), array $arOptions = array())
{
foreach ($data as $menu):
$DL = $menu['DEPTH_LEVEL'];

if( $DL!=1 ):?>
<div class="i_hmenu_div_<?=$DL?> jq_hmenu_div_<?=$DL?>">
	<a href="<?=$menu['SECTION_PAGE_URL']?>" class="i_hmenu_a_<?=$DL;if($DL==1 && $menu['I_CHILD'])echo ' i_hmenu_arrow jq_hmenu_arrow';if($menu['I_SELECTED'])echo ' i_hmac_'.$menu['DEPTH_LEVEL']?>">
		<span><?echo $menu['NAME'];if( ($DL==1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$menu['ELEMENT_CNT'].')'?></span>
	</a>
	<?endif?>

	<?
	if($menu['I_CHILD']):
	if(!$menu['UF_COLUM_MENU']) $menu['UF_COLUM_MENU'] = 3;
	?>

	<div jq_hm_col="<?if( $menu['UF_COLUM_MENU'] )echo $menu['UF_COLUM_MENU']; else echo '3';?>" class="i_col_<?=$menu['UF_COLUM_MENU'];?> <?if($menu['I_PRODUCT']) echo 'i_hsub_item ';?>i_hsub_<?=$DL?> jq_hsub_<?=$DL;if($DL==1)echo ' ivhid'?>" jq_hm_open="<?=$menu['ID']?>"<?/*if( $menu['UF_COLUM_MENU'] )echo ' jq_hm_col="'.$menu['UF_COLUM_MENU'].'" style="width:'.$menu['I_COLUM_WIDTH'].'px"'*/?>>
		<?if($menu['I_PRODUCT'])
			echo '<div class="i_vmline ipabs"></div>'?>
		<? if($DL==1): ?>
		<div class="i_hsub_title"><?=$menu['UF_SUBTITLE']?></div>
		<div class="jq_hor_shapeshift iprel" data-col="<?=$menu['UF_COLUM_MENU'];?>">
			<? endif; $arParams['ITEM_VIEW'] = 'CatalogMenuItem'; ?>
			<?if($menu['I_PRODUCT'])
				i_showItem($APPLICATION, array('FROM'=>'MENU'), $product[$menu['I_PRODUCT']], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php

			i_h_view_cat($menu['I_CHILD'], array(), $arParams, array());

			if($DL==1)echo '</div>'?>
		</div>
		<?endif?>

		<?if( $DL!=1 )echo '</div>'?>
		<?endforeach;
		}?>

		<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>

		<nav class="i_hmenu jq_hmenu iprel<?if($arParams['I_MENU_LINE']=='Y')echo ' i_hmenu_line';if($arParams['I_COLOR_SCHEME']=='Y')echo ' i_hmenu_color'?><?if( $arParams['I_MENU_ICON_TOP']=='Y' ) echo ' i_hmenu_v1';?>">

			<?$i=1;foreach($arResult['ITEMS'] as $e):
				$DL = $e['DEPTH_LEVEL'];
				// Инвертация картинок
				if( $e['I_WHITE'] && $arParams['I_COLOR_SCHEME']=='Y' && $arParams['I_REVERSE_IMAGE']=='Y' ) {
					if($e['I_IMG']) $first = $e['I_IMG'];
					else  $first		= $e['~PICTURE'];
					$second		= $e['I_WHITE'];
				} else {
					$first		= $e['I_WHITE'];
					if($e['I_IMG']) $second	= $e['I_IMG'];
					else $second = $e['~PICTURE'];
				}?>

				<a href="<?=$e['SECTION_PAGE_URL']?>" class="i_hmenu_a_<?=$DL;if( $DL==1 && $e['I_CHILD'] )echo ' jq_hmenu_arrow';if( $e['I_SELECTED'] )echo ' i_hmac_'.$e['DEPTH_LEVEL'];if( $e['~PICTURE'] && ($arParams['I_REMOVE_ICON']=='N') )echo ' iveralti'?>"<?if( $DL==1 && $i==$co)echo ' style="width:'.$l_w.'px"';elseif( $DL==1 )echo ' style="width:'.$w.'px"';if($DL==1 && $e['I_CHILD'])echo ' jq_hm_open="'.$e['ID'].'"'?>>
					<div class="i_hmenu_out_1 iprel<?if( $arParams['I_MENU_ICON_TOP']=='Y' ) echo ' i_hmenu_out_v1';?>">
						<?if( $arParams['I_MENU_ICON_TOP']=='Y' ):?>
							<?if( $arParams['I_REMOVE_ICON']=='N' ):?>
								<div class="i_hmenu_vimg_1">
									<?if( $e['I_WHITE'] && $arParams['I_COLOR_SCHEME']=='Y' )
										echo CFile::ShowImage($e['I_WHITE'], 100, 100, 'class="i_hm_img_white"');?>
								</div>
							<?endif?>
							<span class="i_hmenu_vspan_1"><span><?echo $e['NAME'];if( $arParams['I_NUMBER_ELEMENT_1LVL']=='Y' )echo ' ('.$e['ELEMENT_CNT'].')'?></span></span>
						<?else:?>
							<?if( $arParams['I_REMOVE_ICON']=='N' ):?>
								<div class="i_hmenu_img_1">
									<?if( $e['I_WHITE'] && $arParams['I_COLOR_SCHEME']=='Y' )
										echo CFile::ShowImage($e['I_WHITE'], 100, 100, 'class="i_hm_img_white"'); ?>
								</div>
							<?endif?>
							<div class="i_hmenu_span_1"><span><?echo $e['NAME'];if( $arParams['I_NUMBER_ELEMENT_1LVL']=='Y' )echo ' ('.$e['ELEMENT_CNT'].')'?></span></div>
						<?endif?>
					</div>
					<?if( $DL==1 && $e['I_CHILD'] )echo '<div class="i_hmenu_arrow"></div>'?>
				</a>

				<?$i++;endforeach?>

			<div class="i_hmenu_drop ipabs">
				<?i_h_view_cat( $arResult['ITEMS'], $arResult['I_PRODUCT'], $arParams, array('I_COUNT'=>$w) )?>
			</div>
		</nav>


		<div class="i_hmenu_mobi idnone jq_h_menu_mobi"><?=GetMessage('CATALOG_TITLE');?></div>
		<div class="i_cmapodmenu  jq_cmapodmenu idnone">
			<?foreach($arResult['ITEMS'] as $e):?>
				<div class="i_cmaitem1">
					<a href="<?=$e['SECTION_PAGE_URL']?>" class="i_cmalink jq_i_cmalink ifont130 iprel">
						<?=$e['NAME']?>
						<?
						/*if($e[$arParams['I_MOBILE_ICON']]) $img = $e[$arParams['I_MOBILE_ICON']];
						else */$img = $e['I_IMG'];
						?>
						<div class="i_cmaicon1_wrap ipabs" style="background-image: url('<?=$img;?>')"></div>
						<?if(!empty($e['I_CHILD'])):?>
							<span class="i_cmastr ipabs i_cmastrr"></span>
						<?endif?>
					</a>
					<?if(!empty($e['I_CHILD'])):?>
						<div class="i_cmapod j_cmapod i_cmaopen0 idnone">
							<?foreach($e['I_CHILD'] as $arSubItem):?>
								<a href="<?=$arSubItem['SECTION_PAGE_URL']?>" class="i_cmalink2 iprel" rel="1"><?=$arSubItem['NAME']?></a>
							<?endforeach?>
						</div>
					<?endif?>
				</div>
			<?endforeach;?>
		</div>


		<?endif
		// ---------------------------------------------------------------------------------------------------- iLaB?>


		<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>


