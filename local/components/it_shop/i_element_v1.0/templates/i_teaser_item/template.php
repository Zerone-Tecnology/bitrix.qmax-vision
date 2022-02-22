<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
$l = strtoupper(LANGUAGE_ID);
$cell = 3;
if( $arParams['I_POINT'] )
	$cell = $arParams['I_POINT'];?>
	<div class="i_teaser_i iprel">

		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>

			<?if( $k>0 && is_int($i/$cell) )
				echo '<div class="iclear"></div></div><div class="i_teaser_i iprel">'?>

				<div class="i_ti_block iprel ifleft<?if( $k>0 && !is_int($i/$cell) )echo ' i_ml10'?>" id="<?=$this->GetEditAreaId($e['ID'])?>">
					<a href="javascript:void(0)" class="i_teaser_i_item jq_teaser_i_item" jq_st_id="<?=$e['ID']?>">
						<?if($e['PREVIEW_PICTURE']):?>
							<div class="i_teaser_i_img i_teaser_i_item_col"><div><img src="<?=$e['PREVIEW_PICTURE']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>"></div></div>
						<?endif?>
							<div class="i_teaser_i_name i_teaser_i_item_col"<?if(!$e['PREVIEW_PICTURE'])echo ' style="width: 100%"'?>>
								<span><?=$e['NAME']?></span>
							</div>
							<div class="iclear"></div>
					</a>
					<div class="i_teaser_i_delta jq_teaser_i_delta ipabs idnone"></div>
				</div>
				<div class="i_teaser_i_modal jq_teaser_i_modal ipabs idnone"  jq_st_id="<?=$e['ID']?>">
					<div class="i_teaser_im_close jq_teaser_im_close ifont160 ipabs">×</div>
					<div class="i_teaser_i_modtxt">
						<h4><?=$e['NAME']?></h4>
						<?=$e['PREVIEW_TEXT']?>
					</div>
					<?if($e['PRO']['I_LINK_'.$l]['VALUE']):?>
						<a href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>">Подробнее</a>
					<?endif?>
				</div>

		<?$i++;endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>