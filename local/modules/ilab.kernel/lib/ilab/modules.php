<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\ilab;

use ilab\kernel\{ilab, general};

class modules
{

	protected static $f = 'modules/';
	protected static $i = '/local/modules/ilab.kernel/lib/ilab/modules/jquery.ilab.js';

	public function init(string $p)
	{

		$br = '<br><br>';
		$hr = '----------------------------------------------------------------------------------------------------'.$br;

//		echo $hr. 'ilab\kernel\ilab\modules::init()'.$br.'$p.self::$f - '.$p.self::$f. $br.$hr;

		// Get Dirs
		$res = general\dirs::List(
			$p.self::$f
		);

		if( !$res )
			return false;
/*
		echo '<pre>';
		echo $l.'ilab\kernel\general\dirs work result pre'.$br;
		print_r($res);
		echo '</pre>';
*/
//		echo self::$i;

// ---------------------------------------------------------------------------------------------------- *TODO - jquery is initialized
		if( true )
			\Bitrix\Main\Page\Asset::getInstance()->addJs(self::$i);// Load js plugin ilab
// ---------------------------------------------------------------------------------------------------- *TODO - jquery is initialized

		foreach ($res as $k=>$v)
		{

//			echo $p.self::$f.$v.'/'. $br;

			// Load css and js
			ilab\css::init($p.self::$f.$v.'/');
			ilab\js::init($p.self::$f.$v.'/');

		}

	}

}