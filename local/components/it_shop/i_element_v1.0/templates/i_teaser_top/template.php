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
		$count = count($arResult['ITEMS']);
	}?>
	<div class="i_teaser_t <?echo 'i_teaser_t'.$count?>">
		<div class="i_teaser_t_col">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<?if($k%2==0 && $k>0):?>
				</div>
				<div class="i_teaser_t_col">
			<?endif;?>
			<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>" class="i_teaser_t_item<?/*if( $k>0 && !is_int($i/$p) )echo ' i_ml20';if( $i>$pm )echo ' i_mt20'*/?>">
				<div class="i_teaser_t_name"<?if(!$e['PREVIEW_PICTURE'])echo ' style="width: 100%"'?>><span><?=$e['NAME']?></span></div>
				<div class="i_teaser_t_content">
					<?if($e['PREVIEW_PICTURE'] && $e['PREVIEW_TEXT']):?>
						<div class="i_teaser_t_img"><img src="<?=$e['PREVIEW_PICTURE']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>"></div>
					<?endif?>
					<?if($e['PREVIEW_TEXT']):?>
						<div class="i_teaser_t_txt<?if($e['PREVIEW_PICTURE'])echo ' i_w144'?>"><?=$e['PREVIEW_TEXT']?></div>
					<?endif?>
				</div>
			</a>
		<?endforeach?>
		</div>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>

<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arParams);?></pre>
<?endif*/?>
