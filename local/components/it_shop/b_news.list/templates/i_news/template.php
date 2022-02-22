<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	if($arParams['DISPLAY_TOP_PAGER'])
		echo $arResult['NAV_STRING'].'<br>'?>

<div class="i_mt25">

	<a href="<?=$arParams['I_TITLE_LINK']?>" class="i_h2"><span><?=GetMessage('NEWS')?></span></a>

	<div class="i_newlist">
		<?foreach($arResult['ITEMS'] as $k=>$e):
			$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($e['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($e['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			if($k>0):?>
				<div class="i_newlist_hr"></div>
			<?endif?>
			<div class="i_newlist_item" id="<?=$this->GetEditAreaId($e['ID']);?>">

				<?	// ----------------------------------------------------------------------------------------------------   PREVIEW_PICTURE
				/*if($arParams['DISPLAY_PICTURE']!='N' && is_array($e['PREVIEW_PICTURE'])):?>
					<div class="i_actionlist_img">
					<?if(!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($e['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS'])):?>
						<a href="<?=$e['DETAIL_PAGE_URL']?>"><img
								border="0"
								src="<?=$e['PREVIEW_PICTURE']['SRC']?>"
								alt="<?=$e['PREVIEW_PICTURE']['ALT']?>"
								title="<?=$e['PREVIEW_PICTURE']['TITLE']?>"
								/></a>
					<?else:?>
						<img
							border="0"
							src="<?=$e['PREVIEW_PICTURE']['SRC']?>"
							alt="<?=$e['PREVIEW_PICTURE']['ALT']?>"
							title="<?=$e['PREVIEW_PICTURE']['TITLE']?>"
							/>
					<?endif?>
					</div>
				<?endif*/
					// ----------------------------------------------------------------------------------------------------   PREVIEW_PICTURE?>

				<?	// ----------------------------------------------------------------------------------------------------   DISPLAY_ACTIVE_FROM
				if($arParams['DISPLAY_DATE']!='N' && $e['DISPLAY_ACTIVE_FROM']):?>
					<div class="i_newlist_date"><?=$e['DISPLAY_ACTIVE_FROM']?></div>
				<?endif
					// ----------------------------------------------------------------------------------------------------   DISPLAY_ACTIVE_FROM?>

				<?	// ----------------------------------------------------------------------------------------------------   NAME
				if($arParams['DISPLAY_NAME']!='N' && $e['NAME']):?>
					<div class="i_newlist_name">
					<?if(!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($e['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS'])):?>
						<a href="<?=$e['DETAIL_PAGE_URL']?>"><span<?if($k==0)echo ' class="ifont110"'?>><?=$e['NAME']?></span></a>
					<?else:?>
						<span<?if($k==0)echo ' class="ifont110"'?>><?=$e['NAME']?></span>
					<?endif?>
					</div>
				<?endif
					// ----------------------------------------------------------------------------------------------------   NAME?>

				<?	// ----------------------------------------------------------------------------------------------------   PREVIEW_TEXT
				if($arParams['DISPLAY_PREVIEW_TEXT']!='N' && $e['PREVIEW_TEXT'] && $k==0):?>
					<div class="i_newlist_txt">
					<?/*if(!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($e['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS'])):?>
						<a href="<?=$e['DETAIL_PAGE_URL']?>"><span<?if($k==0)echo ' class="ifont110"'?>><?=$e['PREVIEW_TEXT']?></span></a>
					<?else:*/?>
						<span<?if($k==0)echo ' class="ifont110"'?>><?=$e['PREVIEW_TEXT']?></span>
					<?//endif?>
					</div>
				<?endif
					// ----------------------------------------------------------------------------------------------------   PREVIEW_TEXT?>
				
				<?/*if($arParams['DISPLAY_PICTURE']!='N' && is_array($e['PREVIEW_PICTURE'])):?>
					<div class="iclear"></div>
				<?endif?>
				<?foreach($e['FIELDS'] as $code=>$value):?>
					<small>
					<?=GetMessage('IBLOCK_FIELD_'.$code)?>:&nbsp;<?=$value;?>
					</small><br />
				<?endforeach?>
				<?foreach($e['DISPLAY_PROPERTIES'] as $pid=>$arProperty):?>
					<small>
					<?=$arProperty['NAME']?>:&nbsp;
					<?if(is_array($arProperty['DISPLAY_VALUE'])):?>
						<?=implode('&nbsp;/&nbsp;', $arProperty['DISPLAY_VALUE']);?>
					<?else:?>
						<?=$arProperty['DISPLAY_VALUE'];?>
					<?endif?>
					</small><br />
				<?endforeach*/?>
			</div>
		<?endforeach?>
		<a href="<?=$arParams['I_TITLE_LINK']?>" class="i_newlist_all"><span><?=GetMessage('NEWS_ALL')?></span></a>
	</div>

</div>

	<?if($arParams['DISPLAY_BOTTOM_PAGER'])
		echo '<br>'.$arResult['NAV_STRING'];
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>