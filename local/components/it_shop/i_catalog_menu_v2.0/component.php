<?
use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// Не волнуйтесь, если что-то не работает. Если бы всё работало, Вас бы уволили.
// ---------------------------------------------------------------------------------------------------- iLaB
$dir = $arParams['I_DIR'];//array_values( array_filter( explode( '/', $arParams['I_DIR'] ) ) );// В каком разделе находимся
$arResult['dir'] = $dir;
$l = strtoupper(LANGUAGE_ID);

if ($this->StartResultCache(false, $arParams['CACHE_GROUPS']==='N'? false: $USER->GetGroups()))
{
	if( !CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') || !CModule::IncludeModule('sale') )
		return;

	$width_colum = 235;// (px) width one colum

	// -------------------------------------------------- DEPTH_LEVEL
	if( !$arParams['I_DEPTH_LEVEL'] || ($arParams['I_DEPTH_LEVEL']>4 || $arParams['I_DEPTH_LEVEL']<1)  )
		$I_DEPTH_LEVEL = 4;
	else
		$I_DEPTH_LEVEL = $arParams['I_DEPTH_LEVEL'];

	$arOrder	= Array('SORT'=>'ASC', 'NAME'=>'ASC');
	$arSelect	= Array('ID','IBLOCK_SECTION_ID','IBLOCK_ID','SECTION_PAGE_URL','DEPTH_LEVEL','UF_LINK','UF_IMG_WHITE', 'UF_PRODUCT', 'UF_COLUM_MENU', 'UF_NAME', 'UF_IMG', 'UF_IMG_2', 'UF_IMG_WHITE', 'UF_I_NAME_KZ', 'UF_I_NAME_RU', 'UF_I_NAME_EN', 'UF_SUBTITLE_'.$l);
	$arFilter	= Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ACTIVE'=>'Y', 'GLOBAL_ACTIVE'=>'Y', '<=DEPTH_LEVEL'=>$I_DEPTH_LEVEL, 'CNT_ACTIVE'=>'Y');

	/*if( $arParams['I_SHOW_SECT_MENU'] )
		$arFilter['!ID'] = $arParams['I_SHOW_SECT_MENU'];*/
	$res = CIBlockSection::GetList($arOrder, $arFilter, true, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$obj = $ob->GetFields();

		$obj['~PICTURE'] = CFile::GetPath($obj['PICTURE']);

		if( $obj['~UF_NAME'] )
			$obj['NAME'] = $obj['~UF_NAME'];

		if( $obj['UF_I_NAME_'.$l] )
			$obj['NAME'] = $obj['UF_I_NAME_'.$l];

		if( $obj['UF_IMG'] )
			$obj['I_WHITE'] = CFile::GetPath($obj['UF_IMG']);

		if( $obj['UF_IMG_WHITE'] )
			$obj['I_IMG'] = CFile::GetPath($obj['UF_IMG_WHITE']);

		if( $obj['UF_SUBTITLE_'.$l] )
			$obj['UF_SUBTITLE'] = $obj['UF_SUBTITLE_'.$l];
		else $obj['UF_SUBTITLE'] = $obj['NAME'];

		// Colum menu
		if( $obj['UF_COLUM_MENU'] )
		{
			if( $obj['UF_COLUM_MENU']>4 )// max 4 columns (default to javascript)
				$obj['UF_COLUM_MENU'] = 4;

			if( $obj['UF_PRODUCT'] && $obj['UF_COLUM_MENU']>3 )// max 3 colums if product (default to javascript)
				$obj['UF_COLUM_MENU'] = 3;

			// width colum
			$obj['I_COLUM_WIDTH'] = $obj['UF_COLUM_MENU']*$width_colum;
			if( $obj['UF_PRODUCT'] )
				$obj['I_COLUM_WIDTH'] = $obj['I_COLUM_WIDTH']+$width_colum;
		}

		if( $obj['UF_LINK'] )
			$obj['SECTION_PAGE_URL'] = $obj['UF_LINK'];

		// SELECTED
		if(mb_strpos($dir, $obj['SECTION_PAGE_URL'])!==false)
		{
			$obj['I_SELECTED'] = 'Y';
//			echo $obj['ID'].'-'.$obj['DEPTH_LEVEL'].'|';
			if( $obj['IBLOCK_SECTION_ID'] )
				$id = $obj['IBLOCK_SECTION_ID'];
		}

		// Товар в меню
		if( $obj['UF_PRODUCT'] )
		{
			$prand = array_rand($obj['UF_PRODUCT']);// Случайный товар

			$obj['I_PRODUCT'] = $obj['UF_PRODUCT'][$prand];
			$arResult['I_PRODUCT_ID'][$obj['ID']] = $obj['UF_PRODUCT'][$prand];
		}

		$arRe[$obj['ID']] = $obj;
	}

	// SELECTED
	if( $id )
	{
		$res = CIBlockSection::GetNavChain( false, $id );
		while($ob = $res->GetNext())
			if( $ob['DEPTH_LEVEL']==1 )
				$arRe[$ob['ID']]['I_SELECTED'] = 'Y';
	}
	/*do{
		echo $arRe[$id]['DEPTH_LEVEL'].'==1<br>';
		$arRe[$id]['I_SELECTED'] = 'Y';
		$id = $arRe[$id]['IBLOCK_SECTION_ID'];

	}while( $arRe[$id]['DEPTH_LEVEL']<1 );*/

	$arResult['ITEMS'] = i_mapTree($arRe);

// ---------------------------------------------------------------------------------------------------- PRODUCT
	if( $arResult['I_PRODUCT_ID'] )// Товар в меню
	{
		// -------------------------------------------------- Measure
		$res = CCatalogMeasure::getList();
		while ($ob = $res->GetNext())
			$arResult['MEASURE'][$ob['ID']] = $ob;
		// -------------------------------------------------- Currency
		$arParams['PRICE_VAT_INCLUDE']	= $arParams['PRICE_VAT_INCLUDE'] !== 'N';
		$arParams['CURRENCY_ID']		= trim(strval($arParams['CURRENCY_ID']));

		if ( $arParams['CURRENCY_ID']=='' )
			$arParams['CONVERT_CURRENCY'] = 'N';

		if ( $arParams['CONVERT_CURRENCY']=='Y' )
			if (!Loader::includeModule('currency'))
			{
				$arParams['CONVERT_CURRENCY']	= 'N';
				$arParams['CURRENCY_ID']		= '';
			} else {
				$currencyIterator = CurrencyTable::getList(array(
					'select' => array('CURRENCY'),
					'filter' => array('CURRENCY' => $arParams['CURRENCY_ID'])
				));
				if ($currency = $currencyIterator->fetch())
				{
					$arParams['CURRENCY_ID']		= $currency['CURRENCY'];
					$arConvertParams['CURRENCY_ID'] = $currency['CURRENCY'];
				}else {
					$arParams['CONVERT_CURRENCY']	= 'N';
					$arParams['CURRENCY_ID']		= '';
				}
				unset($currency, $currencyIterator);
			}
		// -------------------------------------------------- Catalog Price
		$arPriceTools	= CIBlockPriceTools::GetCatalogPrices($arParams['IBLOCK_ID'], $arParams['I_PRICE_CODE']);

		$arOrder	= Array('SORT'=>'ASC');
		$arFilter	= Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ID'=>$arResult['I_PRODUCT_ID'], 'ACTIVE'=>'Y');
//		$arNav		= Array('nTopCount'=>1);
		$arSelect	= Array('IBLOCK_ID','ID','IBLOCK_SECTION_ID','CATALOG_MEASURE','PREVIEW_PICTURE','NAME','DETAIL_PAGE_URL');
		foreach($arPriceTools as $e)
			$arSelect[] = $e['SELECT'];

		$ires = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
		while($obj = $ires->GetNext())
		{
			//$obj				= $ob->GetFields();
			//$obj['PROPERTIES']	= $ob->GetProperties();

			//IMG
			$picture = $obj['PREVIEW_PICTURE'];
			$obj['PREVIEW_PICTURE'] = array();
			$obj['PREVIEW_PICTURE']['SRC']	= CFile::GetPath($picture);

			// PRICES
			$obj['PRICES']		= CIBlockPriceTools::GetItemPrices(	$arParams['IBLOCK_ID'], $arPriceTools, $obj, $arParams['PRICE_VAT_INCLUDE'], $arConvertParams);
			$obj['CAN_BUY']		= CIBlockPriceTools::CanBuy(		$arParams['IBLOCK_ID'], $arPriceTools, $obj);
			// MIN_PRICE
			if( $obj['PRICES'] )
				foreach($obj['PRICES'] as $p)
					if($p['MIN_PRICE']=='Y')
					{	$obj['MIN_PRICE'] = $p;	break;	}

			// EDIT
			$arButtons = CIBlock::GetPanelButtons(
				$obj['IBLOCK_ID'],
				$obj['ID'],
				$obj['IBLOCK_SECTION_ID'],
				array('SECTION_BUTTONS'=>false, 'SESSID'=>false)
			);
			$obj['EDIT_LINK']	= $arButtons['edit']['edit_element']['ACTION_URL'];
			$obj['DELETE_LINK']	= $arButtons['edit']['delete_element']['ACTION_URL'];

			// MEASURE
			$obj['CATALOG_MEASURE_NAME']	= $arResult['MEASURE'][$obj['CATALOG_MEASURE']]['SYMBOL_RUS'];
			$obj['~CATALOG_MEASURE_NAME']	= $arResult['MEASURE'][$obj['CATALOG_MEASURE']]['~SYMBOL_RUS'];

			$rsRatios = CCatalogMeasureRatio::getList(
				array(),
				array('PRODUCT_ID' => $obj['ID']),
				false,
				false,
				array('PRODUCT_ID', 'RATIO')
			);
			/*echo '<pre class="ipre">';
			print_r($obj);
			echo '</pre>';*/
			while ($arRatio = $rsRatios->Fetch())
			{
				$arRatio['PRODUCT_ID'] = (int)$arRatio['PRODUCT_ID'];

				$intRatio = (int)$arRatio['RATIO'];
				$dblRatio = doubleval($arRatio['RATIO']);
				$mxRatio = ($dblRatio > $intRatio ? $dblRatio : $intRatio);
				if (CATALOG_VALUE_EPSILON > abs($mxRatio))
					$mxRatio = 1;
				elseif (0 > $mxRatio)
					$mxRatio = 1;
				$obj['CATALOG_MEASURE_RATIO'] = $mxRatio;
			}

			$arResult['I_PRODUCT'][$obj['ID']] = $obj;
		}
// ---------------------------------------------------------------------------------------------------- OFFERS
		if( $arResult['I_PRODUCT_ID'] )
		{
			$offersFilter = array(
				'IBLOCK_ID'				=> $arParams['IBLOCK_ID'],
				'HIDE_NOT_AVAILABLE'	=> $arParams['HIDE_NOT_AVAILABLE']
			);
			if( $arParams['SHOW_PRICE_COUNT'] )
				$offersFilter['SHOW_PRICE_COUNT'] = $arParams['SHOW_PRICE_COUNT'];// НЕ документированно для матрицы цен
			if( !$arParams['HIDE_NOT_AVAILABLE'] )
				$arParams['HIDE_NOT_AVAILABLE'] = 'Y';
			$arParams['OFFERS_FIELD_CODE'] = $arParams['OFFERS_PROPERTY_CODE'] = array();
			$arParams['OFFERS_LIMIT'] = 0;

			$arOffers = CIBlockPriceTools::GetOffersArray(
				$offersFilter
				,$arResult['I_PRODUCT_ID']
				,array('SORT'=>'ASC')
				,$arParams['OFFERS_FIELD_CODE']
				,$arParams['OFFERS_PROPERTY_CODE']
				,$arParams['OFFERS_LIMIT']
				,$arPriceTools
				,$arParams['PRICE_VAT_INCLUDE']
				,$arConvertParams
			);

			if(!empty($arOffers))
			{
				foreach($arResult['I_PRODUCT_ID'] as $id)
					$arResult['I_PRODUCT'][$id]['OFFERS'] = array();

				foreach($arOffers as $arOffer)
				{
					//			$arResult['OFFERS'][] = $arOffers;
					if (isset($arResult['I_PRODUCT'][$arOffer['LINK_ELEMENT_ID']]))
						$arResult['I_PRODUCT'][$arOffer['LINK_ELEMENT_ID']]['OFFERS'][] = $arOffer;
				}
			}
		}
	}

	// -------------------------------------------------- UNSET
	if( $arParams['I_SHOW_SECT_MENU'] )
		foreach ($arResult['ITEMS'] as $k=>$e)
			if( in_array($k, $arParams['I_SHOW_SECT_MENU']) )
				unset($arResult['ITEMS'][$k]);

	$this->IncludeComponentTemplate();
}
// ---------------------------------------------------------------------------------------------------- iLaB
/*
	$arSelect = Array('ID', 'NAME', 'IBLOCK_SECTION_ID');
	$arFilter = Array('IBLOCK_ID'=>$arParams[''], 'ACTIVE'=>'Y');
	$res = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, false, $arSelect);
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{

		$obj			= $ob->GetFields();
		$obj['PRO']	= $ob->GetProperties();

		$arButtons = CIBlock::GetPanelButtons(
			$obj['IBLOCK_ID'],
			$obj['ID'],
			$arResult['ID'],
			array('SECTION_BUTTONS'=>false, 'SESSID'=>false, 'CATALOG'=>true)
		);
		$obj['EDIT_LINK']		= $arButtons['edit']['edit_element']['ACTION_URL'];
		$obj['DELETE_LINK']	= $arButtons['edit']['delete_element']['ACTION_URL'];
	}

	$arParams['']
	$arResult['']
*/
// ---------------------------------------------------------------------------------------------------- iLaB?>