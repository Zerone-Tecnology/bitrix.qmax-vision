<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult ):

	if( !$arParams['I_POINT'] )
	{
		foreach($arResult as $e)
			if( !$e['IS_PARENT'] )
				$po++;
		$arParams['I_POINT'] = (int)ceil( $po/3 );// Вычисляем столбцы
	}


endif
// ---------------------------------------------------------------------------------------------------- iLaB?>