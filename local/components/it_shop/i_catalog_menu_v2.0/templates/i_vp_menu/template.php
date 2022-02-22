<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	// Frame
	$frame = $this->createFrame('jq_vmenu', false)->begin();
//	$frame->setAnimation(true);?>

	<?function i_vp_menu($data, $arParams, $arOption)
	{
		foreach ($data as $m):
			$DL = $m['DEPTH_LEVEL'];
			$L1 = $DL==1;// Первый уровень
			$LE = $DL>1;// Остальные кроме 1 уровня

			$lvl = $LE ? '_'.$DL : '';
			$sel = $m['I_SELECTED'] ? ' i_vp_selected' : '';

			$ul = 'i_vp_ul'.$lvl.' '.'j_vp_ul';
			$li = 'i_vp_li'.$lvl.' '.'j_vp_li'.$sel;
			$a  = 'i_vp_a' .$lvl.' '.'j_vp_a' .$lvl;
            if( $m['I_WHITE'] && $arParams['I_COLOR_SCHEME']=='Y' && $arParams['I_REVERSE_IMAGE']=='Y' ) {
                if($m['I_IMG']) $first = $m['I_IMG'];
                else  $first		= $m['~PICTURE'];
                $second		= $m['I_WHITE'];
            } else {
                $first		= $m['I_WHITE'];
                if($m['I_IMG']) $second	= $m['I_IMG'];
                else $second = $m['~PICTURE'];
            }?>

			<li class="<?=$li?>">
                <?if ($L1) echo '<div class="i_arrow_block_in"></div>'?>
                <?if ($L1) echo '<div class="i_arrow_block_on"></div>'?>
				<a
				href="<?=$m['SECTION_PAGE_URL']?>"
				class="i_vp_link j_vp_link<?if( $m['I_CHILD'] )echo ' i_vp_sub j_vp_sub'?>"><?//echo $L1 ? 'i_vp_link j_vp_link' : $a;?>
                    <?if( $DL==1 && $m['I_IMG'] ):?>
                        <span class="i_vp_img"<?//if( $m['I_IMG'] )echo ' st yle="background-image: url('.$first.')"'?>>
                            <?echo CFile::ShowImage($first, 100, 100, 'class="i_vp_img_white"').CFile::ShowImage($second, 100, 100, 'class="i_vp_img_inverted idnone"');?>
                       </span>
                    <?endif?>
					<span class="i_vp_name"><?echo $m['NAME'];if( ($L1 && $arParams['I_NUMBER_ELEMENT_1LVL']=='Y') || ($DL>1 && $arParams['I_NUMBER_ELEMENT_NLVL']=='Y') )echo ' ('.$m['ELEMENT_CNT'].')'?></span>
				</a>
				<?if( $m['I_CHILD'] ):?>
                    <?if ($L1) echo '<div class="i_vp_column_cont inner-content scrollbar-outer">'?>
                    <ul
					class="<?=$ul;// if( $L1 )echo ' idn'?>  <?//if ($L1) echo 'j_vp_ul_scrollbar scrollbar-inner'?>"
					<?if( $L1 )echo ' style="column-count: '.$m['UF_COLUM_MENU'].'"'?>>
						<?i_vp_menu( $m['I_CHILD'], $arParams, array() );?>
						<li class="i_vp_product">
							<?if($m['I_PRODUCT'])
								i_showItem($APPLICATION, array('FROM'=>'MENU'), $m['I_PRODUCT'], $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php?>
						</li>
					</ul>
                    <?if ($L1) echo '</div>'?>
				<?endif?>
			</li>

		<?endforeach;
	}?>

<?/*$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?*/$frame->end()?>

	<nav class="i_vp_menu_bl j_vp_menu_bl<?=' '.$arParams['i_HIEW']?> " data-height='<?=$arParams['I_HEIGHT']?>'>
		<div class="i_vp_title j_vp_title">
			<span class="i_vpt_x j_vpt_x<?if( $arResult['I_SELECTED'] )echo ' i_vpt_x_selected'?>"><div class="i_vpt_icon j_vpt_icon"></div></span>
            <?/*=GetMessage('CATALOG')*/?>
            <div class="i_vp_catalog_name">
                <span>Каталог</span>
                <span>товаров</span>
            </div>
		</div>
            <ul class="i_vp_menu j_vp_menu">
                <div class="i_arrow_bot"></div>
                <div class="i_vp_scroll_one">
                    <div class="i_vp_li_cont j_vp_li_cont j_vp_scrollbar scrollbar-inner">
                <?i_vp_menu( $arResult['ITEMS'], $arParams, array() )?>
                <?if( $arParams['I_MORE']=='Y' ):?>
                    <li class="i_vp_li j_vp_li i_vp_more j_vp_more">
                        <span class="i_vp_link j_vp_link i_vp_sub j_vp_sub i_vp_span">
                            <span class="i_vp_img"></span>
                            <span class="i_vp_name">Еще</span>
                        </span>
                            <ul class="i_vp_ul j_vp_ul i_vp_inside j_vp_inside"></ul>
                    </li>
                <?endif?>
                    </div>
                </div>
            </ul>
		<div class="i_vp_toggle j_vp_toggle">
			<span class="i_vp_x j_vp_x"><div class="i_vp_icon j_vp_icon"></div></span>
		</div>
	</nav>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre class=""><?print_r($arResult)?></pre>
<?endif*/?>