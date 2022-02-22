// Выгрузка из 1С характеристик торговых предложений в отдельные свойства v2.0
$eventManager = \Bitrix\Main\EventManager::getInstance();

//$eventManager->addEventHandlerCompatible('iblock',	'OnAfterIBlockElementUpdate',	array('ext1cHandler', 'attributeFieldToProps'));
//$eventManager->addEventHandlerCompatible('iblock',	'OnAfterIBlockElementAdd',		array('ext1cHandler', 'attributeFieldToProps'));
//$eventManager->addEventHandlerCompatible('catalog',	'OnBeforeProductUpdate',		array('ext1cHandler', 'attributeQuant'));
//$eventManager->addEventHandlerCompatible('catalog',	'OnBeforeProductAdd',			array('ext1cHandler', 'attributeQuant'));

class ext1cHandler
{
	const CML2_ATTRIBUTES_NAME = 'CML2_TRAITS';// CML2_ATTRIBUTES

	private static $enumListProps = array();

	public static function attributeFieldToProps($arResult)
	{

//		if (!self::is1cSync()) return true;

//		AddMessage2Log("\n".'Вызов функции'."\n".print_r($arResult,true), 'attributeFieldToProps:');

		$arParams = self::getIblockProps($arResult['IBLOCK_ID']);

		if (empty($arParams) || !is_array($arParams)) return;

		//получаем массив значений множественного свойства CML2_ATTRIBUTES в которое стандартно выгружаются характеристики ТП из 1С
		$res = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], array('sort' => 'asc'), array('CODE' => self::CML2_ATTRIBUTES_NAME));
		while ($ob = $res->GetNext())
		{

			if( $ob['DESCRIPTION'] )
			{

				$Tn = 'INPR_'.self::getTranslit($ob['DESCRIPTION']);
				$Tv = self::getTranslit($ob['VALUE']);

				$arParams['PRODUCT']['PROP'][$Tn] = $ob['DESCRIPTION'];
				$arParams['PRODUCT']['VALUES'][$Tv] = $ob['VALUE'];
				$arParams['PRODUCT']['RESULT'][$Tn][] = $Tv;

			}

		}unset($res,$ob,$Tn,$Tv);

		$arParams['RESULT'] = $arParams['PRODUCT']['RESULT'] + array_diff_key($arParams['CURRENT']['INPR'], $arParams['PRODUCT']['PROP']);

//		if( $arParams['RESULT']['INPR_KOLICHESTVO_TOVAROV'] )
//			unset($arParams['RESULT']['INPR_KOLICHESTVO_TOVAROV']);

//		AddMessage2Log('ARRAY_PARAMS ----->'."\n".print_r($arParams,true)."\n".'ARRAY_PARAMS <-----', 'attributeFieldToProps:');


		if( $arParams['RESULT'] )foreach($arParams['RESULT'] as $p=>$v)
		{

			if( !isset($arParams['CURRENT']['PROP'][$p]) )// Если нет свойства то добавим
			{

				$arFields = array(
					'NAME'			=> $arParams['PRODUCT']['PROP'][$p],
					'ACTIVE'		=> 'Y',
					'SORT'			=> '700',
					'CODE'			=> $p,
					'PROPERTY_TYPE'	=> 'L',// Список
					'MULTIPLE'		=> 'Y',// Множественный
					'IBLOCK_ID'		=> $arResult['IBLOCK_ID'],
					'VALUES'		=> array(),
				);

				$ibp = new CIBlockProperty;
				if($propId = $ibp->Add($arFields))
				{

					$arParams['CURRENT']['PROP'][$p] = $propId;

//					AddMessage2Log("\n".'Добавлено новое свойство: '.$arParams['PRODUCT']['PROP'][$p].' | CODE: '.$p.' | ID: '.$propId, 'attributeFieldToProps:');

				}unset($ibp,$arFields);

			}

			if( isset($arParams['CURRENT']['PROP'][$p]) && $v )// Если есть свойство
			{

				// !!!!!----- Сбросим все значение свойства
				CIBlockElement::SetPropertyValues($arResult['ID'], $arResult['IBLOCK_ID'],
					array( 'VALUE' => '' )
				, $arParams['CURRENT']['PROP'][$p]);

				$EnumListProp = self::getEnumListProp($arResult['IBLOCK_ID'], $arParams['CURRENT']['PROP'][$p]);

				/*echo '<pre>';
				print_r($EnumListProp);
				echo '<br>----------<br>';
				echo '</pre>';*/

				foreach($v as $vl)// множественные значение
					if( !isset($EnumListProp[$arParams['CURRENT']['PROP'][$p]][$vl]) )// то добавим значение
					{
						$ibpenum = new CIBlockPropertyEnum;
						$arFieldsEnum = array(
							'XML_ID'		=> $vl,
							'PROPERTY_ID'	=> $arParams['CURRENT']['PROP'][$p],
							'VALUE'			=> $arParams['PRODUCT']['VALUES'][$vl]
						);

						if($enumPropValueId = $ibpenum->Add($arFieldsEnum))
						{

							$EnumListProp[$arParams['CURRENT']['PROP'][$p]][$vl] = $enumPropValueId;

//							AddMessage2Log("\n".'Добавлено новое значение: '.$arParams['PRODUCT']['VALUES'][$vl].' | XML_ID: '.$vl.' | ID: '.$enumPropValueId.' | В свойство: '.$arParams['PRODUCT']['PROP'][$p], 'attributeFieldToProps:');

						}unset($ibpenum,$arFieldsEnum);

					}

				/*echo '<pre>';
				print_r($EnumListProp);
				echo '</pre>';*/


				// выберем нужные множественные значения
				CIBlockElement::SetPropertyValues($arResult['ID'], $arResult['IBLOCK_ID'], 
					self::MultiPropetyMap($v, $EnumListProp[$arParams['CURRENT']['PROP'][$p]])
				, $arParams['CURRENT']['PROP'][$p]);

//				AddMessage2Log("\n".'Выберем значение: '."\n".print_r($v,true)."\n".' | В свойстве: '.$arParams['PRODUCT']['PROP'][$p].' | '.$arParams['CURRENT']['PROP'][$p].' | У товара c ID: '.$arResult['ID'], 'attributeFieldToProps:');
