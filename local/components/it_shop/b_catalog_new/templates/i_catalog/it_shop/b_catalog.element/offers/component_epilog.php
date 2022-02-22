<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	// Сопутствующие товары/Похожие товары -element.php
	unset($_SESSION['I_PRICE_SIMILAR']);
	unset($_SESSION['I_RELATED']);

	if( $arResult['CACHE_MIN_PRICE'] && ($arParams['I_CHECK_SIMILAR']=='Y') )
		$_SESSION['I_PRICE_SIMILAR']	= $arResult['CACHE_MIN_PRICE']['DISCOUNT_VALUE'];

	if( $arResult['CACHE_RELATED'] && ($arParams['I_CHECK_RELATED']=='Y') )
		$_SESSION['I_RELATED']			= $arResult['CACHE_RELATED'];

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>