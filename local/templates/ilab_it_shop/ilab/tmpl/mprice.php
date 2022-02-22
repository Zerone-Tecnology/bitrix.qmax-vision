<?
$arResult['PRICE_MATRIX']			= $PRICE_MATRIX;
$arResult['FIRST_MATRIX_ID']		= $FIRST_MATRIX_ID;
$arResult['PRICE_MATRIX_OFFERS']	= $PRICE_MATRIX_OFFERS;?>

<div class="i_matrix_block jq_matrix_block">
	<?i_matrix_price(array('ID'=>$arResult['FIRST_MATRIX_ID']), $arResult['PRICE_MATRIX']);?>
	<?if( $arResult['PRICE_MATRIX_OFFERS'] )
		foreach($arResult['PRICE_MATRIX_OFFERS'] as $ik=>$ie)
			foreach($ie as $e)
				i_matrix_price(array('ID'=>$ik, 'SKU'=>'Y'), $e);?>
</div>