<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);

CurrencyFormat($arResult['PROPERTIES']['MAXIMUM_PRICE']['VALUE'], $arResult['I_BASE_CURRENCY']);

// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
		$p	= 2;
		$pm	= 1;
	if( $arParams['I_POINT'] )
	{
		$p	= $arParams['I_POINT'];
		$pm	= $p-1;
	}?>

	<? $countItems = count($arResult['ITEMS']) ?>

	<div class="i_special_offers i_mt25 aclear">
		<?if($arParams['I_TITLE']):?>
			<a class="i_h2" href=""><span><?=$arParams['I_TITLE']?></span></a>
		<?endif?>
		<div class="i_special_offers_cnt">
			<? foreach($arResult['ITEMS'] as $k=>$e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
				<?if($k%2==0):?>
					<div class="i_special_offers_block">
				<?endif?>
				<div class="i_special_offers_item<?if($arParams['I_POINT']==1 || $countItems%2==1 && $k==$countItems-1) echo ' i_special_offers_item_w100'?><?/*if( $k>0 && !is_int($i/$p) )echo ' i_ml20';if( $i>$pm )echo ' i_mt20'*/?>" style="background-image: url(<?=$e['PREVIEW_PICTURE']?>)">
					<a id="<?=$this->GetEditAreaId($e['ID']);?>" href="<?=$e['PRO']['I_LINK_'.$l]['VALUE']?>">

						<?if($e['PRO']['I_PRICE']['VALUE']):?>
							<div class="i_special_offers_item_price">
								<span class="i_special_offers_item_price_text"><?echo GetMessage('I_SP_ONLY_FOR');?></span><br>
								<span class="i_special_offers_item_price_price"><?=CurrencyFormat($e['PRO']['I_PRICE']['VALUE'],$arResult['I_BASE_CURRENCY'])?></span>
							</div>
						<?endif?>
						<div class="i_special_offers_item_name">
							<span><?=$e['NAME']?></span></div>
					</a>
				</div>
				<?if($k%2==1):?>
					</div>
				<?endif?>
				<?$i++; endforeach?>
		</div>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>