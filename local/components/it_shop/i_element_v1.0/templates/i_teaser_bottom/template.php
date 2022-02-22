<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
		$p	= 4;
		$pm	= 3;
	if( $arParams['I_POINT'] )
	{
		$p	= $arParams['I_POINT'];
		$pm	= $p-1;
	}?>
	<div class="i_teaser_b <?= 'i_teaser_b_'.count($arResult['ITEMS'])?>">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<?if($k%2 == 0):?>
				<div class="i_teaser_b_block">
			<?endif?>
			<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>" class="i_teaser_b_item">
				<div class="i_teaser_b_item_cnt">
					<div class="i_teaser_b_name"<?if(!$e['PREVIEW_PICTURE'])echo ' style="width: 100%"'?>><?=$e['NAME']?></div>
				<?if($e['PREVIEW_PICTURE']):?>
					<div class="i_teaser_b_img"><img src="<?=$e['PREVIEW_PICTURE']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>"></div>
				<?endif?>
				</div>
			</a>
			<?if($k%2 != 0):?>
			</div>
			<?endif?>
		<?$i++;endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arResult);?></pre>
<?endif*/?>