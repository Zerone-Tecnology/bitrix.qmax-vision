<?
use \Bitrix\Main\Application;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult ):

	/* Перенаправление на эту же страницу другой языковой версии */
	$request = Application::getInstance()->getContext()->getRequest();
	$uriString = $request->getRequestUri();

	$dir = explode('?',$uriString);

	if( LANGUAGE_ID=='ru' )
		$newDir = substr($dir[0], 1);
	else {
		$newDir = implode('/', array_slice(array_filter(explode('/', $dir[0])), 1));

		if( $newDir )
			$newDir .= '/';
	}

	foreach($arResult['SITES'] as &$v)
	{
		$v['DIR'] = $v['DIR'].$newDir;
	}unset($v);

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($dir)?>
		<?print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>