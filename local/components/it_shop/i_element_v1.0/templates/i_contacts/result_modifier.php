<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// Нельзя просто так взять и подключить карты :)
// Не включать КЭШ компоненты!
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
	foreach ($arResult['ITEMS'] as $k=>$e):

		// NAME
		if( $e['PRO']['I_NAME_'.$l]['VALUE'] )
			$arResult['ITEMS'][$k]['NAME'] = $e['PRO']['I_NAME_'.$l]['VALUE'];

		foreach($e['PRO'] as $ik=>$ie):// Карты
			if($ie['USER_TYPE'] == 'map_yandex' && $ie['VALUE']){// Yandex карты

				$p_yandex = explode(',', $ie['VALUE']);
				ob_start();// -------------------------------------------------- ob_start
				$APPLICATION->IncludeComponent(
					'it_shop:b_map.yandex.view',
					'',
					Array(
						'INIT_MAP_TYPE' => 'MAP',
						'MAP_DATA' => serialize(array(
							'yandex_lat'	=> $p_yandex[0],
							'yandex_lon'	=> $p_yandex[1],
							'yandex_scale'	=> 16,
							'PLACEMARKS'	=> array(
								array(
//											'TEXT'	=> $e['PREVIEW_TEXT'],
									'LAT'	=> $p_yandex[0],
									'LON'	=> $p_yandex[1],
								)
							),
						)),
						'MAP_WIDTH' => '100%',
						'MAP_HEIGHT' => '320',
						'CONTROLS' => array(
//									'TOOLBAR',
							'ZOOM',
//									'SMALLZOOM',
//									'MINIMAP',
//									'TYPECONTROL',
							'SCALELINE',
//									'SEARCH',
						),
						'OPTIONS' => array(
							'ENABLE_DBLCLICK_ZOOM',
							'ENABLE_SCROLL_ZOOM',
							'ENABLE_DRAGGING',
						),
						'MAP_ID' => 'i_yandex_'.$ie['PROPERTY_VALUE_ID']
					),
					array('HIDE_ICONS'=>'Y')
				);
				$arResult['ITEMS'][$k]['I_MAP'] = ob_get_contents();
				ob_end_clean();// -------------------------------------------------- ob_end_clean
				break;

			}elseif($ie['USER_TYPE'] == 'map_google' && $ie['VALUE']){// Google карты

				$p_google = explode(',', $ie['VALUE']);
				ob_start();// -------------------------------------------------- ob_start
				$APPLICATION->IncludeComponent(
					'it_shop:b_map.google.view',
					'',
					Array(
						'INIT_MAP_TYPE' => 'ROADMAP',
						'MAP_DATA' => serialize(array(
							'google_lat'	=> $p_google[0],
							'google_lon'	=> $p_google[1],
							'google_scale'	=> 16,
							'PLACEMARKS'	=> array(
								array(
//											'TEXT'	=> $e['PREVIEW_TEXT'],
									'LAT'	=> $p_google[0],
									'LON'	=> $p_google[1],
								)
							),
						)),
						'MAP_WIDTH' => '100%',
						'MAP_HEIGHT' => '320',
						'CONTROLS' => array(
							'SMALL_ZOOM_CONTROL',
//									'TYPECONTROL',
							'SCALELINE',
						),
						'OPTIONS' => array(
							'ENABLE_DBLCLICK_ZOOM',
							'ENABLE_SCROLL_ZOOM',
							'ENABLE_DRAGGING',
//									'ENABLE_KEYBOARD',
						),
						'MAP_ID' => 'i_google_'.$ie['PROPERTY_VALUE_ID']
					),
					array('HIDE_ICONS'=>'Y')
				);
				$arResult['ITEMS'][$k]['I_MAP'] = ob_get_contents();
				ob_end_clean();// -------------------------------------------------- ob_end_clean
				break;

			}
		endforeach;


	endforeach;
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>