<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

use Bitrix\Main\Application;

class dirs
{

	public static function List(string $path)
	{

		// $_SERVER['DOCUMENT_ROOT']
		$docRoot = Application::getDocumentRoot();

		if( $path && file_exists($docRoot.$path) )
		{

			// directories
			$root = array_diff(scandir($docRoot.$path), ['..', '.']);

			foreach($root as $f)
				if( is_dir($docRoot.$path.$f) )
					$result[] = $f;
			unset($f);

			return $result;

		} else
			return false;

	}

}