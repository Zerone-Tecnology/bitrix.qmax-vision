<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace Ilab\Ok;

use Bitrix\{Main, Catalog, Sale};

class Viewed
{
	public function getProductIds ($arParams)
	{
		if (!Main\Loader::includeModule('sale') || !Main\Loader::IncludeModule('catalog'))
		{
			return array();
		}

		$skipUserInit = false;
		if (!Catalog\Product\Basket::isNotCrawler())
			$skipUserInit = true;

		$basketUserId = (int)Sale\Fuser::getId($skipUserInit);
		if ($basketUserId <= 0)
		{
			return array();
		}

		/*if ($arParams['IBLOCK_MODE'] === 'single')
		{
			$ids = array_values(Catalog\CatalogViewedProductTable::getProductSkuMap(
				$arParams['IBLOCK_ID'],
				$arParams['SECTION_ID'],
				$basketUserId,
				$arParams['SECTION_ELEMENT_ID'],
				$arParams['PAGE_ELEMENT_COUNT'],
				$arParams['DEPTH']
			));
		}
		else
		{*/
			$ids = array();
			$filter = array(
				'=FUSER_ID' => $basketUserId,
				'=SITE_ID' => Main\Context::getCurrent()->getSite()
			);

			if ($arParams['SECTION_ELEMENT_ID'] > 0)
			{
				$filter['!=ELEMENT_ID'] = $arParams['SECTION_ELEMENT_ID'];
			}

			$viewedIterator = Catalog\CatalogViewedProductTable::getList(array(
				'select' => array('ELEMENT_ID'),
				'filter' => $filter,
				'order' => array('DATE_VISIT' => 'DESC'),
				'limit' => $arParams['PAGE_ELEMENT_COUNT'] * 10
			));
			while ($viewedProduct = $viewedIterator->fetch())
			{
				$ids[] = (int)$viewedProduct['ELEMENT_ID'];
			}

			/*$this->filterFields = $this->getFilter();
			$this->filterFields['IBLOCK_ID'] = array_keys($this->arParams['SHOW_PRODUCTS']);
			$this->initPricesQuery();

			$ids = array_slice($this->filterByParams($ids, array(), false), 0, $this->arParams['PAGE_ELEMENT_COUNT']);*/
	//	}

		return $ids;
	}
}