<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

use	Bitrix\Main\Page;

class asset
{
	public function Css($arFiles)
	{

		if( $arFiles )
		{

			foreach ($arFiles as $f)
				Page\Asset::getInstance()->addCss($f);

			return true;

		} else
			return false;

	}

	public function Js($arFiles)
	{

		if( $arFiles )
		{

			foreach ($arFiles as $f)
				Page\Asset::getInstance()->addJs($f);

			return true;

		} else
			return false;

	}

}