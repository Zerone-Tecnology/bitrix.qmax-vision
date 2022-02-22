<?

namespace Ilab\Core;

/*
	Класс для манипуляций с ценами
*/

class Price
{

	/*
	 	Price::MaxPrice(); Метод для поиска максимальной цены товара
	*/

	public function MaxPrice(array $arPrices)
	{

		$max = 0;

		foreach($arPrices as $code=>$arPrice)
			if($arPrice['CAN_ACCESS'])
			{
				// max
				$v = $arPrice['VALUE'];

				if( $max > 0 && $v > $max )
				{
					$max = $v;
					$maxItemPrice = $arPrice;
				}
				elseif( $max == 0 )
				{
					$max = $v;
					$maxItemPrice = $arPrice;
				}

				// min
				$min = $arPrice['MIN_PRICE'] ? $arPrice['DISCOUNT_VALUE'] : 0;
			}

		//echo $max.' > 0 && '.$max.' > '.$min.'<br>';

		if( $max > 0 && $max > $min )
		{
			$result = [
				'ID' => $maxItemPrice['ID'],
				'CAN_ACCESS' => $maxItemPrice['CAN_ACCESS'],

				'VALUE' => $max,
				'PRINT_VALUE' => $maxItemPrice['PRINT_VALUE'],
			];
		} else
			$result = false;

		/*echo ' ---------------------------------------------------------------------------------------------------- MaxPrice ';
		echo '<pre>';
		print_r($result);
		print_r($maxItemPrice);
		echo '</pre>';
		echo ' ---------------------------------------------------------------------------------------------------- MaxPrice '.'<br>';*/

		return $result;

	}

}