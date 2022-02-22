<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	require_once($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/ilab/php/functions.php');

	if( !CModule::IncludeModule('iblock') || !CModule::IncludeModule('catalog') )
		return;

	$ar = explode('↕', $_POST['idiblock']);
//	$ar = array(20,812);

	$arFilter = Array('IBLOCK_ID'=>$ar[0], 'ID'=>$ar[1], 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter);
	while($ob = $res->GetNextElement())
	{
		$ob_do = $ob->GetFields();
		$ob_do['PRO'] = $ob->GetProperties();

		$arResult = $ob_do;
	}

	$photo = false;

	/*if( count($arResult['PRO']['MORE_PHOTO']['VALUE'])==1 )
		$arResult['PRO']['MORE_PHOTO']['VALUE'] = array($arResult['PRO']['MORE_PHOTO']['VALUE']);
	if( count($arResult['PRO']['I_MORE_PHOTO']['VALUE'])==1 )
		$arResult['PRO']['I_MORE_PHOTO']['VALUE'] = array($arResult['PRO']['I_MORE_PHOTO']['VALUE']);*/

	// MORE_PHOTO
	if(isset($arResult['PRO']['MORE_PHOTO']['VALUE']) && is_array($arResult['PRO']['MORE_PHOTO']['VALUE']))
		foreach($arResult['PRO']['MORE_PHOTO']['VALUE'] as $FILE)
		{
			$FILE = CFile::GetFileArray($FILE);
			if(is_array($FILE))
				$arResult['MORE_PHOTO'][]=$FILE;
		}
	// I_MORE_PHOTO
	if(isset($arResult['PRO']['I_MORE_PHOTO']['VALUE']) && is_array($arResult['PRO']['I_MORE_PHOTO']['VALUE']))
		foreach($arResult['PRO']['I_MORE_PHOTO']['VALUE'] as $FILE)
		{
			$FILE = CFile::GetFileArray($FILE);
			if(is_array($FILE))
				$arResult['MORE_PHOTO'][]=$FILE;
		}

	if( $arResult['MORE_PHOTO'] )// Картинка
	{
			$photo = '<div class="i_cele_img_sw jq_cele_img_sw_'.$arResult['ID'].' swiper-container ifleft"><div class="swiper-wrapper">';
					foreach($arResult['MORE_PHOTO'] as $i):
						$photo .= '<div class="swiper-slide">';
							$photo .= '<a class="i_cele_image jq_fancybox_'.$arResult['ID'].'" style="background-image: url('.$i['SRC'].')" data-fancybox="images_'.$arResult['ID'].'" href="'.$i['SRC'].'" title="'.$arResult['NAME'].'"></a>';
						$photo .= '</div>';
					endforeach;
			$photo .= '</div></div><div class="i_cele_nav_img_block jq_cele_nav_img_block_'.$arResult['ID'].'">';
					foreach($arResult['MORE_PHOTO'] as $k=>$i):
						$reImage = CFile::ResizeImageGet($i, Array('width'=>100, 'height'=>100));

						$act = ' i_cele_nav_act';
						if($k>0)
							unset($act);

							$photo .= '<span style="background-image: url(data:image/jpg;base64,'.base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].$reImage['src'])).')" class="i_cele_nav_img jq_cele_nav_img ifleft'.$act.'" rel="'.$k.'" alt="'.$arResult['NAME'].'" title="'.$arResult['NAME'].'"></span>';
					endforeach;
			$photo .= '</div>';
	}

	echo $photo;

} else
	echo 'DataError';
// ---------------------------------------------------------------------------------------------------- iLaB
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>