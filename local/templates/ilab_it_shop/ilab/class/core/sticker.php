<?

namespace Ilab\Core;

/*
	Класс для манипуляций с стикерами
*/

class Sticker
{

	/*
		Sticker::List(); Метод для Стикеров
	*/

	public function List(array $sticker, array $e)
	{

		if($sticker)
			foreach($sticker as $ie)
				if( $e['PROPERTIES'][$ie]['VALUE'] )
					$result[] = $ie;

		if( $e['MIN_PRICE']['CAN_ACCESS'] && ($e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE']) )
			$result[] = 'I_DISCOUNT_DIFF_PERCENT';

		return $result;

	}

}