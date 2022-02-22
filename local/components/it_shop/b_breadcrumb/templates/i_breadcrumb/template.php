<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));
require_once('result_modifier.php');
//$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if(empty($arResult))
	return '';

$strReturn = '<div class="i_breadcrumbs"><ul>';

$strReturn .= '<li><a href="'.SITE_DIR.'" title="'.GetMessage('MAIN').'">'.GetMessage('MAIN').'</a></li>';

$num_items = count($arResult);
for($index = 0, $itemSize = $num_items; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]['TITLE']);

	if($arResult[$index]['LINK'] <> '' && $index != $itemSize-1)
		$strReturn .= '<li><a href="'.$arResult[$index]['LINK'].'" title="'.$title.'">'.$title.'</a></li>';
	else
		$strReturn .= '<li><span>'.$title.'</span></li>';
}

$strReturn .= '</ul></div>';

return $strReturn;
// ---------------------------------------------------------------------------------------------------- iLaB?>