<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	// Frame
	$frame = $this->createFrame('jq_vmenu', false)->begin();
//	$frame->setAnimation(true);?>

	<?function i_v_menu($APPLICATION ,$data, $arParams, $arOption, $arProduct)
	{
		foreach ($data as $m):
			$DL = $m['DEPTH_LEVEL'];
			$L1 = $DL==1;// Первый уровень
			$LE = $DL>1;// Остальные кроме 1 уровня
			$PM = $L1 && $arProduct[ $m['ID'] ];

			$lvl = $LE ? '_'.$DL : '';
			$sel = $m['I_SELECTED'] ? ' i_vm_selected'.$lvl : '';
			$pro = $PM ? ' i_vm_product i_cs_tile' : '';

			$ul = 'i_vm_ul'.$lvl.' '.'j_vm_ul'.$lvl.$pro;
			$li = 'i_vm_li'.$lvl.' '.'j_vm_li'.$lvl.$sel;
			$a  = 'i_vm_a' .$lvl.' '.'j_vm_a' .$lvl;?>

			<li class="<?=$li?> j_vm_li_all">
				<a
				href="<?=$m['SECTION_PAGE_URL']?>"
				class="<?=$a; if( $m['I_CHILD'] )echo ' i_vm_sub j_vm_sub'?>">
					<?if( $m['I_IMG'] ):?>
						<span class="i_img_block">
							<div class="i_img_or" style="background-image: url('<?=$m['I_IMG']?>')"></div>
							<div class="i_img_inv idn" style="background-image: url('<?=$m['I_WHITE']?>')"></div>
						</span>
					<?endif;?>
					<?echo $m['NAME'];if( ($L1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$m['ELEMENT_CNT'].')'?>
				</a>
				<?if( $m['I_CHILD'] ):?>
					<ul
							class="<?=$ul; if( $L1 )echo ' idn'; if( $LE )echo' j_vm_ul_all_2'?> j_vm_ul_all"
						<?if( $L1 )echo ' style="column-count: '.$m['UF_COLUM_MENU'].'"'?>>
						<?i_v_menu($APPLICATION, $m['I_CHILD'], $arParams, array(), array() );?>
						<?if( $PM ):?>
							<li class="i_vm_item">
								<?i_showItem($APPLICATION, array('FROM'=>'MENU'), $arProduct[ $m['ID'] ], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php?>
							</li>
						<?endif?>
					</ul>
				<?endif?>
			</li>

		<?/*?>

			<div class="i_vmenu_div_<?=$DL?> jq_vmenu_div_<?echo $DL;if( $arOption['POS'] == 'Y') echo ' iprel'?>">

				<a href="<?=$menu['SECTION_PAGE_URL']?>" class="i_vmenu_a_<?=$DL;if($DL==1 && $menu['I_CHILD'])echo ' i_vmenu_arrow jq_vmenu_arrow';if($menu['I_SELECTED'])echo ' i_vmac_'.$menu['DEPTH_LEVEL']?>"<?if( $menu['~PICTURE'] )echo 'style="background-image: url('.$menu['~PICTURE'].')"'?>>

						<?echo $menu['NAME'];if( ($DL==1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$menu['ELEMENT_CNT'].')'?>

				</a>

				<?if($menu['I_CHILD']):?>
					<div class="i_vsub_<?=$DL?> jq_vsub_<?=$DL;if($DL==1)echo ' ivhid'?>">
						<?if($menu['I_PRODUCT'])
							echo '<div class="i_vmline ipabs"></div>'?>
						<?if($DL==1)echo '<div class="jq_ver_shapeshift iprel">'?>
						<?if($menu['I_PRODUCT'])
							i_showItem($APPLICATION, array('FROM'=>'MENU'), $menu['I_PRODUCT'], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php

							i_v_view_cat($menu['I_CHILD'], $arParams, array());

						if($DL==1)echo '</div>'?>
					</div>
				<?endif?>

			</div>
		<?*/endforeach;
	}?>

<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>

	<nav class="i_v_menu_bl j_v_menu_bl<?=' '.$arParams['I_VIEW']?>" data-height='<?=$arParams['I_HEIGHT']?>'>
		<div class="i_vm_arrow"></div>
		<div class="i_vm_title j_vm_title">
			<span class="i_vmt_x j_vmt_x"><div class="i_vmt_icon j_vmt_icon"></div></span>
			<?=GetMessage('CATALOG')?>
		</div>
		<ul class="i_v_menu j_v_menu">
			<?i_v_menu($APPLICATION, $arResult['ITEMS'], $arParams, [], $arResult['I_PRODUCT_MENU'] )?>
		</ul>
		<div class="i_vm_toggle j_vm_toggle">
			<span class="i_vm_x j_vm_x"><div class="i_vm_icon j_vm_icon"></div></span>
		</div>
	</nav>

	<?/*if( $arParams['I_MENU_EXTENSION'] == 'Y' ):?>
		<nav class="ic_vmenu iprel jq_vmenu i_heauto">
			<div class="i_vmenu_catalog iprel ifont110"><?=GetMessage('CATALOG')?></div>
			<div class="i_vmenu_out jq_vmenu_out iprel i_heauto">
				<div class="i_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arParams, array('POS'=>'N') )?>
				</div>
			</div>
		</nav>
	<?elseif( !CSite::InDir(SITE_DIR.'index.php') && $arParams['I_HIDE_MENU'] == 'Y' ):?>
		<nav class="ic_vmenu jq_vmenu iprel">
			<div class="i_vmenu_catalog jqc_vmenu_catalog iprel ifont110 ibr5i"><span class="i_vmenu_carrb jq_vmenu_catarr"><?=GetMessage('CATALOG')?></span></div>
			<div class="ic_vmenu_out jqc_vmenu_out ipabs ivhid">
				<div class="ic_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arParams, array('POS'=>'Y') )?>
				</div>
			</div>
		</nav>
	<?else:?>
		<nav class="i_vmenu jq_vmenu iprel">
			<div class="i_vmenu_catalog jq_vmenu_catalog iprel ifont110"><span class="i_vmenu_carrb jq_vmenu_catarr"><?=GetMessage('CATALOG')?></span></div>
			<div class="i_vmenu_out jq_vmenu_out iprel iohidden">
				<div class="i_vmenu_in jq_vmenu_in">
					<?i_v_view_cat( $arResult['ITEMS'], $arParams, array('POS'=>'N') )?>
					<div class="i_vmenu_empty"></div>
					<div class="i_vmenu_div_1 i_buttom_vmenu jq_buttom_vmenu ipabs"></div>
				</div>
			</div>
		</nav>
	<?endif*/?>



<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>