<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( CSite::InDir(SITE_DIR.'catalog/') )
{
/*
	$dir = $APPLICATION->GetCurDir();

	// SELECTED
	if(mb_strpos($dir, $ob_do['SECTION_PAGE_URL'])!==false)
	{
		$ob_do['I_SELECTED'] = 'Y';
//			echo $ob_do['ID'].'-'.$ob_do['DEPTH_LEVEL'].'|';
		if( $ob_do['IBLOCK_SECTION_ID'] )
			$id = $ob_do['IBLOCK_SECTION_ID'];
	}
	$arRe[$ob_do['ID']] = $ob_do;

	// SELECTED
	if( $id )
	{
		$res = CIBlockSection::GetNavChain( false, $id );
		while($ob = $res->GetNext())
			if( $ob['DEPTH_LEVEL']==1 )
				$arRe[$ob['ID']]['I_SELECTED'] = 'Y';
	}
*/
} else {
	foreach ($arResult as $k=>$e)
		if($e['LINK'] == '/personal/')
			$arResult[$k]['LINK'] = '/personal/orders/';
}
// ---------------------------------------------------------------------------------------------------- iLab?>