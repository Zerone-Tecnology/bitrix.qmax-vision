<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Highloadblock as HL;
// ---------------------------------------------------------------------------------------------------- iLaB PHP Functions
// Дерево меню
function i_mapTree($data)
{
	$tree = array();
	foreach ($data as $id=>&$node)
		if (!$node['IBLOCK_SECTION_ID'])
			$tree[$id] = &$node;
		else
			$data[$node['IBLOCK_SECTION_ID']]['I_CHILD'][$id] = &$node;
	return $tree;
}unset($node);
// Цены
function i_price($arr, $min)
{
	foreach($arr as $k=>$e)
		if( $e['CAN_ACCESS'] == 'Y' && $min < $e['DISCOUNT_VALUE'] )
		{ $pr=$k; $min=$e['DISCOUNT_VALUE']; }

	if($pr)
		return $pr;
	else
		return false;
}
// Цена и валюта, деление
function i_price_currency_division($arr)
{
	$pr = preg_split('/\s(?=[^0-9])/', $arr);
	return $pr;
}
// Цена и название цены, деление
function i_price_text($name, $price)
{
	foreach($name as $k=>$e)
		if ($e['ID'] == $price['PRICE_ID'])
			$price_name = $e['TITLE'];
	if($price_name)
		return $price_name;
	else
		return false;
}
// Сортировка свойств оформление заказа
function ilab_sort_prop ($arr1, $arr2)
{
	if( is_array($arr1) || is_array($arr2) )
	{
		if( is_array($arr1) )
			foreach($arr1 as $e)
				$arRe[$e['SORT']][] = $e;

		if( is_array($arr2) )
			foreach($arr2 as $e)
				$arRe[$e['SORT']][] = $e;

		ksort($arRe);

		foreach($arRe as $e)
			foreach($e as $ie)
				$result[] = $ie;

		return $result;
	} else
		return false;
}
// SKU свойства
function ilab_getSkuPropsData($arr)
{
	/*
		На данный момент, информационные блоки могут иметь свойства следующих типов:
		S — строка
		N — число
		L — список
		F — файл
		G — привязка к разделу
		E — привязка к элементу
		S:UserID — Привязка к пользователю
		S:DateTime — Дата/Время
		E:EList — Привязка к элементам в виде списка
		S:FileMan — Привязка к файлу (на сервере)
		S:map_yandex — Привязка к Яndex.Карте
		S:HTML — HTML/текст
		S:map_google — Привязка к карте Google Maps
		S:ElementXmlID — Привязка к элементам по XML_ID
	*/
	$bUseHLIblock = CModule::IncludeModule('highloadblock');

	foreach($arr as $arProp)
	{
		if ($arProp['PROPERTY_TYPE'] == 'L' || $arProp['PROPERTY_TYPE'] == 'E' || $arProp['PROPERTY_TYPE'] == 'S' || ($arProp['PROPERTY_TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory'))
		{
			if ($arProp['XML_ID'] == 'CML2_LINK')
				continue;

			if ($arProp['PROPERTY_TYPE'] == 'L')// Тип список
			{
				$rsPropEnums = CIBlockProperty::GetPropertyEnum($arProp['ID'], Array(), Array('VALUE'=>$arProp['VALUE']));
				while ($arEnum = $rsPropEnums->Fetch())
				{
					$arValues[] = array(
						'ID'		=> $arEnum['ID'],
						'NAME'		=> $arEnum['VALUE'],
						'CODE'		=> $arEnum['CODE'],
						'VALUE'		=> $arEnum['VALUE'],
					);
				}
			}
/*
			// OLD no work version
			elseif ($arProp['PROPERTY_TYPE'] == 'E')
			{

				$rsPropEnums = CIBlockElement::GetList(
					array('SORT' => 'ASC'),
					array('IBLOCK_ID' => $arProp['LINK_IBLOCK_ID'], 'ACTIVE' => 'Y'),
					false,
					false,
					array('ID', 'NAME', 'PREVIEW_PICTURE')
				);
				while ($arEnum = $rsPropEnums->Fetch())
				{
					$arEnum['PREVIEW_PICTURE'] = CFile::GetFileArray($arEnum['PREVIEW_PICTURE']);

					if (!is_array($arEnum['PREVIEW_PICTURE']))
					{
						$arEnum['PREVIEW_PICTURE'] = false;
					}

					if ($arEnum['PREVIEW_PICTURE'] !== false)
					{
						$productImg = CFile::ResizeImageGet($arEnum['PREVIEW_PICTURE'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, false, false);
						$arEnum['PREVIEW_PICTURE']['SRC'] = $productImg['src'];
					}

					$arValues['n'.$arEnum['ID']] = array(
						'ID'		=> $arEnum['ID'],
						'NAME'		=> $arEnum['NAME'],
						'SORT'		=> $arEnum['SORT'],
						'PICT'		=> $arEnum['PREVIEW_PICTURE']
					);
				}

			}
*/
			elseif ($arProp['PROPERTY_TYPE'] == 'E')
			{
				$rsPropEnums = CIBlockElement::GetList(
					array('SORT' => 'ASC'),
					array('IBLOCK_ID' => $arProp['LINK_IBLOCK_ID'], 'ID'=>$arProp['VALUE'], 'ACTIVE' => 'Y'),
					false,
					false,
					array('ID', 'NAME', 'PREVIEW_PICTURE', 'PROPERTY_IMG', 'PROPERTY_MORE_PHOTO')
				);
				while ($arEnum = $rsPropEnums->Fetch())
				{
					$arEnum['PREVIEW_PICTURE'] = CFile::GetFileArray($arEnum['PREVIEW_PICTURE']);

					if( $arEnum['PROPERTY_IMG_VALUE'] )
						$arEnum['PREVIEW_PICTURE'] = CFile::GetFileArray($arEnum['PROPERTY_IMG_VALUE']);

					if (!is_array($arEnum['PREVIEW_PICTURE']))
					{
						$arEnum['PREVIEW_PICTURE'] = false;
					}

					if ($arEnum['PREVIEW_PICTURE'] !== false)
					{
						$productImg = CFile::ResizeImageGet($arEnum['PREVIEW_PICTURE'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, false, false);
						$arEnum['PREVIEW_PICTURE']['SRC'] = $productImg['src'];
					}

					$arValues[] = array(
						'ID'		=> $arEnum['ID'],
						'NAME'		=> $arEnum['NAME'],
						'SORT'		=> $arEnum['SORT'],
//						'PICT'		=> $arEnum['PREVIEW_PICTURE'],
						'CODE'		=> $arEnum['PREVIEW_PICTURE']['SRC'],
						'VALUE'		=> $arEnum['PREVIEW_PICTURE']['SRC']
					);
				}

			}
			elseif ($arProp['PROPERTY_TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory')// Картинки hiload инфоблоки
			{
				if ($bUseHLIblock)
				{
					$hlblock = HL\HighloadBlockTable::getList(array('filter' => array('TABLE_NAME' => $arProp['USER_TYPE_SETTINGS']['TABLE_NAME'])))->fetch();
					if ($hlblock)
					{
						$entity = HL\HighloadBlockTable::compileEntity($hlblock);
						$entity_data_class = $entity->getDataClass();
						$rsData = $entity_data_class::getList(array('filter'=>array('UF_XML_ID'=>$arProp['VALUE'])));

						while ($arData = $rsData->fetch())
						{
							$arValues[] = array(
								'ID'			=> $arData['UF_XML_ID'],
								'NAME'			=> $arData['UF_NAME'],
								'CODE'			=> $arData['UF_XML_CODE'],
								'VALUE'			=> CFile::GetPath($arData['UF_FILE']),
							);
						}

					}
				}
			} elseif ($arProp['VALUE']) {// Остальные если есть VALUE
				$arValues[]	= array(
					'ID'		=> $arProp['ID'],
					'NAME'		=> $arProp['NAME'],
					'CODE'		=> $arProp['CODE'],
					'VALUE'		=> $arProp['VALUE'],
				);
			}
		}
	}

	return $arValues;
}
//метод класса, который добавляет свойство (код/значение) к заказу, динамически узнавая идентификатор свойства
function ilab_AddOrderProperty($code, $value, $order)
{
	if(!strlen($code))
		return false;

	if(CModule::IncludeModule('sale'))
	{
		if($arProp = CSaleOrderProps::GetList(array(), array('CODE' => $code))->Fetch())
		{
			return CSaleOrderPropsValue::Add(array(
				'NAME'			=> $arProp['NAME'],
				'CODE'			=> $arProp['CODE'],
				'ORDER_PROPS_ID'	=> $arProp['ID'],
				'ORDER_ID'		=> $order,
				'VALUE'			=> $value,
			));
		}
	}
}
function i_matrix_price($p, $arr)
{?>
	<div class="i_matrix jq_matrix<?if($p['SKU'])echo ' idnone';if( $arr['I_MULTI_PRICE']!='Y' )echo ' idnonei'?>" jqmpsku="<?=$p['ID']?>" jqmpfirst="<?=$arr['MIN_PRICE']?>">
		<?$arrIn = $arr['ROWS'];
		foreach($arr['ROWS'] as $k=>$e):?>
			<div class="i_mptr">
				<?if(count($arr['ROWS']) > 1 || count($arr['ROWS']) == 1 && ($arr['ROWS'][0]['QUANTITY_FROM'] > 0 || $arr['ROWS'][0]['QUANTITY_TO'] > 0)):?>
					<div class="i_mptd i_mpcol">
						<?if(IntVal($e['QUANTITY_FROM']) > 0 && IntVal($e['QUANTITY_TO']) > 0)
							echo $e['QUANTITY_FROM'].' - '.$e['QUANTITY_TO'];
						elseif(IntVal($e['QUANTITY_FROM']) > 0)
							echo $e['QUANTITY_FROM'].' <span class="i_mtcol">и более</span>';
						elseif(IntVal($e['QUANTITY_TO']) > 0)
							echo '1 - '.$e['QUANTITY_TO'];
						else
							echo ''?>
					</div>
				<?endif;
				$minPrice = false;
				$maxPrice = false;
				foreach($arr['COLS'] as $typeID=>$arType)
				{
					$PRICE = $arr['MATRIX'][$typeID][$k]['DISCOUNT_PRICE'];

					if($minPrice === false || $minPrice > $PRICE && $PRICE)
					{
						$minPrice	= $PRICE;
						$cur		= $arr['MATRIX'][$typeID][$k]['CURRENCY'];
					}

					if($maxPrice === false || $maxPrice < $PRICE && $PRICE)
					{
						$maxPrice	= $PRICE;
						$cur		= $arr['MATRIX'][$typeID][$k]['CURRENCY'];
					}
					$arrIn[$k]['PRICE'] = $minPrice;
				}
				echo '<b class="i_mptd i_mpnumb">'.FormatCurrency($minPrice, $cur).'</b>';?>
			</div>
		<?endforeach;
		if( $arrIn )
		{
			$i=0;foreach($arrIn as $e)
			{
				if($i>0)
					$v .= '*';

				$v .= $e['QUANTITY_FROM'].'|'.$e['QUANTITY_TO'].'|'.$e['PRICE'];
				$i++;
			}
		} elseif( $arr['MIN_PRICE'] )
			$v = '0|0|'.$arr['MIN_PRICE'];?>

		<input type="hidden" class="jq_mparr" value="<?=$v?>">

		<?
		/*
							[0]
								(
									[QUANTITY_FROM]
									[QUANTITY_TO]
									[PRICE]
								)

							[1]
								(
									[QUANTITY_FROM]
									[QUANTITY_TO] 
									[PRICE]
								)

							[2]
								(
									[QUANTITY_FROM]]
									[QUANTITY_TO]
									[PRICE]
								)
		*/
		?>
	</div>
<?}?>