<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

use	Bitrix\Main\Application;

use ilab\kernel;

class autoloader
{

	static public $ilab = 'ilab\\';

	static public function ClassLoadDir($n)
	{

		if( stripos($n, self::$ilab)===false )
			return false;
//$n = 'ilab\dev\ok\test\test';
		$name = $n;
		$docRoot = Application::getDocumentRoot();

//		echo $n.'<br>';

		$n = strtolower($n);
//		echo $n.'<br>';

		$n = substr(strstr($n, '\\'), 1);
//		echo $n.'<br>'.'<br>';

//		$s = strstr($n,'\\', true);
//		echo '$s: '.$s.'<br>';
//		$e = substr(strstr($n,'\\'),1);
//		echo '$e: '.$e.'<br><br>';

		/*if( $s=='dev' )
		{
			$s = $s.'\\'.strstr($e,'\\', true);
			$e = substr(strstr($e,'\\'),1);
		}*/

//		echo '$s: '.$s.'<br>';
//		echo '$e: '.$e.'<br>';

		$n = 'class\\'.$n;

//		echo $n.'<br>';

		$n = str_replace('\\', '/', $n);
//		echo $n.'<br>'.'<br>'.'<br>'.'<br>';

//		$end = substr(strstr($n,'\\'),1);
//		echo 'end: '$end.'<br>';


		/*echo '<pre>';
		print_r($n);
		echo '</pre>';*/

//echo $n;
//var_dump(strpos($n, self::$core)===false);
//var_dump(strpos($n, self::$dev)===false);

//echo 'RETURN FALSE';
//echo $f.'<br>'.'<br>'.'<br>';


//echo $n.'<br>'.'<br>';

//echo substr($n,0,strrpos($n,'\\')+1).'<br>';
//$n = substr($n,0,strrpos($n,'\\')+1).'class\\'.substr(strrchr($n, '\\'), 1);
//echo $n.'<br>';
//$n = strtolower(str_replace('\\', '/', $n));
//echo $n.'<br>'.'<br>'.'<br>'.'<br>';

//		$n = explode('\\', $n);
//		$i = array_shift($n);
//		$n = strtolower(str_replace('\\', '/', $n));

		/*echo '<pre>';
		print_r($i);
		echo '</pre>';

		echo '<pre>';
		print_r($n);
		echo '</pre>';*/

		//echo __DIR__.DIRECTORY_SEPARATOR.'ilab'.DIRECTORY_SEPARATOR;

		//echo 'work|['.$docRoot.kernel\init::$p.$n.'.php'.']|work'.'<br>';


		// Up 17.06.2018
			$file = false;

			if( $n )
				foreach(kernel\init::$p as $p)
					if(	file_exists( $f = $docRoot.$p.$n.'.php' ) && is_file($f) )
					{
						$file = $f;
						break;
					}

			$file ? include($file) : die('Fatal error: Class \''.str_replace('/', '\\', $name).'\' not found! ilab module');

/*
			// OLD
			if( $n )
				file_exists( $f = $docRoot.kernel\init::$p.$n.'.php' ) && is_file($f) ? include($f) : die('Fatal error: Class \''.str_replace('/', '\\', $name).'\' not found! ilab module');
*/

				/*if( file_exists( $f = $docRoot.kernel\init::$p.'/'.$n.'.php' ) && is_file($f) )
				{
					echo $f.'<br>';
					include $f;
				}
				else
				{
					echo $f.'<br>';
					die('Fatal error: Class \''.str_replace('/', '\\', $n).'\' not found! ilab module');
				}*/


	}
}