<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS'] && count($arResult['ITEMS']) > 2):
	$count = count($arResult['ITEMS']);
	$l = strtoupper(LANGUAGE_ID);
		$p	= 4;
		$pm	= 3;
	if( $arParams['I_POINT'] )
	{
		$p	= $arParams['I_POINT'];
		$pm	= $p-1;
	}?>
	<div class="i_tr_tp <?echo 'i_tr_tp_'.$count?>">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>" class="i_tr_tp_item">
				<div class="i_tr_tp_cont">
					<div class="i_tr_tp_name"><span><?=$e['NAME']?></span></div>
					<div class="i_tr_tp_p">
						<?if($e['PREVIEW_PICTURE']):?>
							<div class="i_tr_tp_img<?if($e['I_CLASS_IMG']) echo ' i_tr_tp_img_'.$e['I_CLASS_IMG'];?>" style="background-image: url(<?=$e['PREVIEW_PICTURE']?>)"></div>
						<?endif?>
						<div class="i_tr_tp_p_name"><span><?=$e['NAME']?></span></div>
						<?if($e['PREVIEW_TEXT']):?>
							<div class="i_tr_tp_txt"><?=$e['PREVIEW_TEXT']?></div>
						<?endif?>
					</div>
				</div>
			</a>
		<?endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>

<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arParams);?></pre>
<?endif*/?>
