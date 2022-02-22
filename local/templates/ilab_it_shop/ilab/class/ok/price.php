<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace Ilab\Ok;

class Price
{

	public function ArrayPriceCurrency ($price_print)
	{

		return preg_split('/\s(?=[^0-9])/', $price_print);

	}

	public function ArrayDiscountPercent ($discount_print)
	{

		return preg_split('/(?=[^0-9])(?=%)/', $discount_print);

	}

	public function ArrayWeightFormated ($weight_print)
	{
		return preg_split('/(?=[^0-9])\s/', $weight_print);
	}

}