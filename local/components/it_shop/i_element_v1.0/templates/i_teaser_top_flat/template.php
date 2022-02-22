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
	<div class="i_teaser_t_fl aclear">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>" class="i_teaser_t_fl_item ifleft<?if( $k>0 && !is_int($i/$p) )echo ' i_ml20';if( $i>$pm )echo ' i_mt20'?>">

				<div class="i_teaser_t_fl_img"><img src="<?=$e['PREVIEW_PICTURE']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>"></div>
				<div class="i_teaser_t_fl_name"><?=$e['NAME']?></div>
				<?/*
					<div class="i_teaser_t_fl_name ifont125 ifleft"<?if(!$e['PREVIEW_PICTURE'])echo ' style="width: 100%"'?>><?=$e['NAME']?></div>
				<?if($e['PREVIEW_PICTURE'] && $e['PREVIEW_TEXT']):?>
					<div class="iclear"></div>
					<div class="i_teaser_t_fl_img ifleft"><div><img src="<?=$e['PREVIEW_PICTURE']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>"></div></div>
				<?endif?>
				<?if($e['PREVIEW_TEXT']):?>
					<div class="i_teaser_t_fl_txt ifleft<?if($e['PREVIEW_PICTURE'])echo ' i_w144'?>"><?=$e['PREVIEW_TEXT']?></div>
				<?endif?>
				<?if($e['PREVIEW_PICTURE'] || $e['PREVIEW_TEXT'])echo '<div class="iclear"></div>'?>
				*/?>
			</a>
		<?$i++;endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>