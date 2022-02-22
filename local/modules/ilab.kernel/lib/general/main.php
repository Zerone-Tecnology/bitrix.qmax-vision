<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

use Bitrix\Main\{Application, Context};

class main
{

	// Multidimensional arguments for functions
	public function ma(&$a)
	{

		if( (count($a, COUNT_RECURSIVE)-count($a))==0 )
			$a = [$a];
		elseif( $a )
			$a = array_values($a);

	}

	public static function InDir($strDir)
	{

		$uri = Context::getCurrent()->getServer()->getRequestUri();

		if( substr($uri, -1, 1)=='/' )
			$uri .= 'index.php';

		return (substr($uri, 0, strlen($strDir))==$strDir);

	}

	public function isAdminSection()
	{

		// Метод используется для идентификации административного раздела сайта /bitrix/admin/.
		// Возвращает true если в этом разделе, и false в остальных случаях
		return Context::getCurrent()->getRequest()->isAdminSection();

	}

	public function isPageSection()
	{
		
		return !Context::getCurrent()->getRequest()->isAdminSection();

	}

	public function GetDefaultSite()
	{

		$rs = \CSite::GetList($by='sort', $order='desc', ['DEFAULT'=>'Y']);

		if($arSite = $rs->Fetch())
			return $arSite;
		else
			return false;

	}

	public function GetDefaultSiteID()
	{

		// ID сайта по умолчанию
		return self::GetDefaultSite()['ID'];

	}

	// Путь до текущего файла
	public function GetPatch($notDocumentRoot=false)
	{

		$docRoot = Application::getDocumentRoot();

		if( $notDocumentRoot )
			return str_ireplace($docRoot, '', dirname(__DIR__));
		else
			return dirname(__DIR__);

	}

	// Проверка версии Bitrix на ядро D7
	public function isVersionD7()
	{

		return CheckVersion(SM_VERSION, '14.00.00');

	}

}