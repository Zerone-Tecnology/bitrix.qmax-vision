<?
	$file = $_SERVER['DOCUMENT_ROOT'].'/local/templates/ilab_it_shop/ilab/php/site_color.php';
	$color = '';
	$view = '';
	if( file_exists($file) )
	{
		$fp = fopen($file, 'r');

		$text = fread($fp, filesize($file));

		fclose($fp);

		$arParameters = explode('|', $text);

		$color = $arParameters[0];
		$view = $arParameters[1];
	}
	else
	{
		$mess = 'Такого файла не существует: '.$file;
	}
?>