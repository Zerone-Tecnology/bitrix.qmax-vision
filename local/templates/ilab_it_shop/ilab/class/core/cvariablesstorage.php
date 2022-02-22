<?

namespace Ilab\Core;

class CVariablesStorage
{

	/*
		Использование:
	 	CVariablesStorage::set('MyCustomID', $arResult["ID"]); #установить значение
		CVariablesStorage::get('MyCustomID'); #получить значение
	*/

	private static $storage = array();

	public static function set($name, $value)
	{
		self::$storage[$name] = $value;
	}

	public static function get($name)
	{
		return self::$storage[$name];
	}

}