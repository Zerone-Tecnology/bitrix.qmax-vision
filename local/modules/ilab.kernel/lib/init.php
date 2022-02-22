<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel;

use Bitrix\Main\{Application, Context};

use ilab\kernel\{ilab, general};

class init
{

//	public static $i = 'ilab';// self::$i;
	public static $p;
	public static $t = '/local/templates/';

	public function __construct($path = ['/local/ilab/', SITE_TEMPLATE_PATH.'/ilab/'])
	{

		if( general\main::isPageSection() )
		{

			// Load siteSelector
			new general\siteSelector;

			// Load folder ilab
			self::$p = (array) $path;
			self::Load();

		}

	}

	public static function AutoLoad()
	{

		if( PHP_SAPI == 'cli' )
			return;

//		$start = microtime(true);

		new init();

//		$time = microtime(true) - $start;
//		printf('Скрипт выполнялся %.4F сек.', $time);

	}

	public static function Load()
	{

		$docRoot = Application::getDocumentRoot();

		foreach(self::$p as $p)
			if( is_dir($docRoot.$p) )
			{

				// Load css and js
				ilab\css::init($p);
				ilab\js::init($p);

				// Load modules/css and modules/js
				ilab\modules::init($p);

				// Load class ilab/class
				spl_autoload_register('ilab\kernel\general\autoloader::ClassLoadDir');

			}

	}

	// todo Ready and Dump method
	//public static function Ready(){}
	//public static function Dump(){}

}