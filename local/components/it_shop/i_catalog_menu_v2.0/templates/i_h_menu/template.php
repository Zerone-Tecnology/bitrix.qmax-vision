<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	// Frame
	$frame = $this->createFrame('jq_vmenu', false)->begin();
//	$frame->setAnimation(true);?>

	<?function i_h_menu($APPLICATION, $data, $arParams, $arOption, $arProduct)
	{
		foreach ($data as $m):
			$DL = $m['DEPTH_LEVEL'];
			$L1 = $DL==1;// Первый уровень
			$LE = $DL>1;// Остальные кроме 1 уровня
			$PM = $L1 && $arProduct[ $m['I_PRODUCT'] ];

			$lvl = $LE ? '_'.$DL : '';
			$sel = $m['I_SELECTED'] ? ' i_hm_selected' : '';
			$pro = $PM ? ' i_hm_product i_cs_tile' : '';

			$ul = 'i_hm_ul'.$lvl.' '.'j_hm_ul'.$pro;
			$li = 'i_hm_li'.$lvl.' '.'j_hm_li'.$sel;
			$a  = 'i_hm_a' .$lvl.' '.'j_hm_a' .$lvl;?>

			<li class="<?=$li?>">
				<a
				href="<?=$m['SECTION_PAGE_URL']?>"
				class="i_hm_link j_hm_link<?if( $m['I_CHILD'] )echo ' i_hm_sub j_hm_sub'?>"><?//echo $L1 ? 'i_hm_link j_hm_link' : $a;?>
					<?if( $L1 && $m['I_WHITE'] ):?>
						<span class="i_hm_img"<?if( $m['I_WHITE'] )echo ' style="background-image: url('.$m['I_WHITE'].')"'?>></span>
					<?endif?>
					<?if( $L1 && $m['I_IMG'] ):?>
						<span class="i_hm_img i_hm_img_mob idn"<?if( $m['I_IMG'] )echo ' style="background-image: url('.$m['I_IMG'].')"'?>></span>
					<?endif?>
					<span class="i_hm_name"><?echo $m['NAME'];if( ($L1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$m['ELEMENT_CNT'].')'?></span>
					<?if( $L1 ):?>
						<div class="i_hm_delta j_hm_delta"></div>
					<?endif?>
				</a>
				<?if( $m['I_CHILD'] ):?>
					<ul
					class="<?=$ul;// if( $L1 )echo ' idn'?>"
					<?if( $L1 )echo ' style="column-count: '.$m['UF_COLUM_MENU'].'"'?>>
						<?i_h_menu( $APPLICATION, $m['I_CHILD'], $arParams, [], [] );?>
						<?if( $PM ):?>
							<li class="i_hm_item">
								<?i_showItem($APPLICATION, ['FROM'=>'MENU'], $arProduct[ $m['I_PRODUCT'] ], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php?>
							</li>
						<?endif?>
					</ul>
				<?endif?>
			</li>

		<?endforeach;
	}?>

<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>

	<nav class="i_h_menu_bl j_h_menu_bl<?//=' '.$arParams['i_HIEW']?>" data-height='<?=$arParams['I_HEIGHT']?>'>
		<div class="i_h_menu_preload"></div>
		<div class="i_hm_title j_hm_title">
			<span class="i_hmt_x j_hmt_x<?if( $arResult['I_SELECTED'] )echo ' i_hmt_x_selected'?>"><div class="i_hmt_icon j_hmt_icon"></div></span>
			<?=GetMessage('CATALOG')?>
		</div>
		<ul class="i_h_menu j_h_menu">
			<?i_h_menu( $APPLICATION, $arResult['ITEMS'], $arParams, [], $arResult['I_PRODUCT'] )?>
			<?if( $arParams['I_MORE']=='Y' ):?>
				<li class="i_hm_li j_hm_li i_h_more j_h_more">
					<span class="i_hm_link j_hm_link i_hm_sub j_hm_sub i_hm_span">
						<span class="i_hm_img"></span>
						<span class="i_hm_name">Еще</span>
						<div class="i_hm_delta j_hm_delta"></div>
					</span>
					<ul class="i_hm_ul j_hm_ul i_h_inside j_h_inside"></ul>
				</li>
			<?endif?>
		</ul>
		<div class="i_hm_toggle j_hm_toggle">
			<span class="i_hm_x j_hm_x"><div class="i_hm_icon j_hm_icon"></div></span>
		</div>
	</nav>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>