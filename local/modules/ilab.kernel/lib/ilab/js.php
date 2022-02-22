<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\ilab;

use ilab\kernel\general;

class js
{

	protected static $arSort = [
		'START' => [
			0 => 'jquery',
			1 => 'inputmask'
		],
		'END' => [
			0 => 'functions',
			1 => 'script'
		]
	];

	protected static $f = 'js/';

	public function init(string $p)
	{

		$br = '<br>';
		$hr = '----------------------------------------------------------------------------------------------------'.$br;

//		echo $hr. 'ilab\kernel\ilab\js::init()'.$br.'$p.self::$f - '.$p.self::$f. $br.$hr;

		// Get
		$res = general\file::GetPath(
			$p.self::$f, 'js', false, true, true, true
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
		$res = general\sort::Map($res['js'], self::$arSort);
/*
		echo '<pre>';
		echo $l.'ilab\kernel\general\sort work result pre'.$br;
		print_r($res);
		echo '</pre>';
*/
		// Asset
		general\asset::Js($res);

	}

}