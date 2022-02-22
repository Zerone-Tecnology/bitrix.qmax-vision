<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS'] && count($arResult['ITEMS']) > 2):
	$l = strtoupper(LANGUAGE_ID);
		$p	= 4;
		$pm	= 3;
	if( $arParams['I_POINT'] )
	{
		$p	= $arParams['I_POINT'];
		$pm	= $p-1;
	}?>
	<div class="i_tr_bt <?= 'i_tr_bt_'.count($arResult['ITEMS'])?>">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>" class="i_tr_bt_item">
				<div class="i_tr_bt_block_cont">
					<div class="i_tr_bt_name"<?if(!$e['PREVIEW_PICTURE'])echo ' style="width: 100%"'?>><?=$e['NAME']?></div>
					<div class="i_tr_bt_img<?if($e['I_CLASS_IMG']) echo ' i_'.$e['I_CLASS_IMG'];?>"<?if($e['PREVIEW_PICTURE']):?> style="background-image: url(<?=$e['PREVIEW_PICTURE']?>)"<?endif;?>></div>
				</div>
			</a>
		<?$i++;endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arResult);?></pre>
<?endif*/?>