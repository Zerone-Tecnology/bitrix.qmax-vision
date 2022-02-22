<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['RUBRICS'] ):

	$l = LANGUAGE_ID;
	$s = Bitrix\Main\Context::getCurrent()->getSite();

	foreach($arResult['RUBRICS'] as $k=>$e)
	{

		/*if( $USER->isAdmin() )
		{
			// Город
			echo $e['CODE'];
			echo '<br>';
			echo substr($e['CODE'], -3, 1);
			echo '<br>';
			echo substr($e['CODE'], -3);
			echo '<br>------<br>';
		}*/

		if( substr($e['CODE'], -3, 1)!='_' || (substr($e['CODE'], -3, 1)=='_' && substr($e['CODE'], -3)=='_'.$s) )
			$arResult['I_RUBRICS'][] = $e;

	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>