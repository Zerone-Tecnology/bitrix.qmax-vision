<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB

function display_date($date, $lang)
{
	$arrDate1 = explode(" ", $date);
	$arrDate = explode("/", $arrDate1[0]);
	if($lang=='RU')
	{
		$arMonth = array(
			'01' => 'января',
			'02' => 'февраля',
			'03' => 'марта',
			'04' => 'апреля',
			'05' => 'мая',
			'06' => 'июня',
			'07' => 'июля',
			'08' => 'августа',
			'09' => 'сентября',
			'10' => 'октября',
			'11' => 'ноября',
			'12' => 'декабря',
		);
		$arYear = 'года';
	}
	if($lang=='KZ')
	{
		$arMonth = array(
			'01' => 'Қаңтар',
			'02' => 'Ақпан',
			'03' => 'Наурыз',
			'04' => 'Сәуір',
			'05' => 'Мамыр',
			'06' => 'Маусым',
			'07' => 'Шілде',
			'08' => 'Тамыз',
			'09' => 'Қыркүйек',
			'10' => 'Қазан',
			'11' => 'Қараша',
			'12' => 'Желтоқсан',
		);
		$arYear = 'жыл';
	}
	elseif($lang=='EN')
	{
		$arMonth = array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		);
		$arYear = 'year';
	}
	return $arrDate[0].' '.$arMonth[$arrDate[1]].' '.$arrDate[2].' '.$arYear;
}


if( $arResult ):

	// Language versions and other modifiers
	foreach( $arResult['ITEMS'] as $key=>$col )
	{
		foreach( $col as $k=>$e )
		{
			// NAME
			if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
				$arResult['ITEMS'][$key][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];
			// PREVIEW TEXT
			if( $e['PRO']['I_PREVIEW_TEXT_'.$l]['VALUE'] )
				$arResult['ITEMS'][$key][$k]['PREVIEW_TEXT'] = $e['PRO']['I_PREVIEW_TEXT_'.$l]['~VALUE']['TEXT'];
			// PREVIEW_PICTURE
			if( $e['PREVIEW_PICTURE'] )
			{
				$arResult['ITEMS'][$key][$k]['PREVIEW_PICTURE_SRC'] = CFile::GetPath($e['PREVIEW_PICTURE']);
			}
			// CREATE_DATE
			if(strlen($e["ACTIVE_FROM"])>0)
				$arResult['ITEMS'][$key][$k]['DISPLAY_ACTIVE_FROM']
					= display_date($e["ACTIVE_FROM"], $l);
			else
				$arResult['ITEMS'][$key][$k]['DISPLAY_ACTIVE_FROM'] = "";
		}
	}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>