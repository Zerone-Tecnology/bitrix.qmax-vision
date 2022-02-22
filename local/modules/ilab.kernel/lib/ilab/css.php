<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\ilab;

use ilab\kernel\general;

class css
{

	protected static $arSort = [
		'START' => [
			0 => 'normalize',
			1 => 'reset',
			2 => 'main',
			3 => 'style',
			4 => 'snippet',
			5 => 'c_ilabshop2',
			6 => 'background',
			7 => 'ab_style'
		]/*,
		'END' => [
			0 => 'style',
			1 => 'color'
		]*/
	];

	public static $exclude = null;/*array(
		'main' => array(
			'IN' => SITE_DIR,
			'EX' => array(
				SITE_DIR.'personal/basket.php',
				SITE_DIR.'personal/order.php'
			)
		),
		'basket' => array(
			SITE_DIR.'personal/basket.php',
			SITE_DIR.'personal/order.php'
		),
		'catalog' => SITE_DIR.'catalog/'
	);*/

	protected static $f = 'css/';

	public function init(string $p)
	{

		$br = '<br>';
		$hr = '----------------------------------------------------------------------------------------------------'.$br;
/*
		echo '<pre>';
		echo $l.'ilab\kernel\general\file work result pre'.$br;
		print_r(self::$exclude);
		echo '</pre>';
*/
//		echo $hr. 'ilab\kernel\ilab\css::init()'.$br.'$p.self::$f - '.$p.self::$f. $br.$hr;

		// Get
		$res = general\file::GetPath(
			$p.self::$f, 'css', self::$exclude, true, true, true
		);

		if( !$res )
			return false;
/*
		echo '<pre>';
		echo $l.'ilab\kernel\general\file work result pre'.$br;
		print_r($res);
		echo '</pre>';
*/
		// Sort
		$res = general\sort::Map($res['css'], self::$arSort);
/*
		echo '<pre>';
		echo $l.'ilab\kernel\general\sort work result pre'.$br;
		print_r($res);
		echo '</pre>';
*/
		// Asset
		general\asset::Css($res);

	}
}