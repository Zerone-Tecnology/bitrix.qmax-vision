<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB PowereD

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$view = $_POST['view'];

	$color = $_POST['color'];

	if($color)
	{
		$file = $_SERVER['DOCUMENT_ROOT'].'/local/templates/ilab_it_shop/ilab/php/site_color.php';
		if( file_exists($file) )
		{
			$fp = fopen($file, 'w+');

			$text = $color.'|'.$view;
			if(fwrite($fp, $text))
			{
				$mess = 'Данные в файл успешно занесены.';
			}
			else
			{
				$mess = 'Ошибка при записи в файл.';
			}
			fclose($fp);
		}
		else
		{
			$mess = 'Такого файла не существует: '.$file;
		}
	}

	if($view)
	{
		$file = $_SERVER['DOCUMENT_ROOT'].'/local/templates/ilab_it_shop/ilab/comp/ru/i_block_top.php';
		if( file_exists($file) )
		{
			$fp = fopen($file, 'w+');

			if($view == 'ver') $template = 'i_block_top_vertical';
			else $template = 'i_block_top_horizontal_store';

			$text = '<?	$APPLICATION->IncludeComponent(
						"it_shop:i_block_v1.0",
						"'.$template.'",
						array(
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "0",
							"COMPONENT_TEMPLATE" => "'.$template.'",
							"COMPOSITE_FRAME_MODE" => "A",
							"COMPOSITE_FRAME_TYPE" => "AUTO"
						),
						false,
						array(
							"ACTIVE_COMPONENT" => "Y"
						)
						);
					?>';
			if(fwrite($fp, $text))
			{
				$mess = 'Данные в файл успешно занесены.';
			}
			else
			{
				$mess = 'Ошибка при записи в файл.';
			}
			fclose($fp);
		}
		else
		{
			$mess = 'Такого файла не существует: '.$file;
		}
	}

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB PowereD
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>