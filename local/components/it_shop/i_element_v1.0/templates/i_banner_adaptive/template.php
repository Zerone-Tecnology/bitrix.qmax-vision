<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Ilab\Core;

$this->setFrameMode(true);
/* Ты это... Заходи, если что © Волк */
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);?>
	<div class="i_banner<?if( count($arResult['ITEMS'])>1 ) echo ' jq_adaptive_banner';if(Core\CVariablesStorage::get('IBLockTemplate')) echo ' '.Core\CVariablesStorage::get('IBLockTemplate');?> swiper-container"<?if( $arParams['I_HEIGHT'] )echo ' style="height:'.$arParams['I_HEIGHT'].'px"'?>>
		<div class="swiper-wrapper">
			<?foreach($arResult['ITEMS'] as $k=>$e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				// Background image
				$bg_img = false;
				$bg_pos = false;
				if( $e['PRO']['I_BACK_POSITION_'.$l]['VALUE'] )
					$bg_pos = 'center '.$bg_img.$e['PRO']['I_BACK_POSITION_'.$l]['VALUE'].'px';
				else
					$bg_pos = 'center top';
				if( $e['D_PRO']['I_BACK_BANNER_'.$l]['FILE_VALUE']['SRC'] )
					$bg_img = ' jqimg="url('.$e['D_PRO']['I_BACK_BANNER_'.$l]['FILE_VALUE']['SRC'].') '.$bg_pos.'" jqpreimg="'.$e['D_PRO']['I_BACK_BANNER_'.$l]['FILE_VALUE']['SRC'].'"';?>

				<div class="swiper-slide"<?=$bg_img?>>
					<?if( $e['PRO']['I_LINK_'.$l]['VALUE'] )echo '<a href="'.$e['PRO']['I_LINK_'.$l]['VALUE'].'">'?>
					<div class="swiper-lazy i_adaptive_banner_img jq_adaptive_banner_img<?if($e['I_POS']) echo ' '.$e['I_POS'];?>" rel="<?=$e['ID']?>"
						 data-src='{
						 	"src1":"<?=$e['D_PRO']['I_LG_BANNER_'.$l]['FILE_VALUE']['SRC']?>",
						 	"src2":"<?=$e['D_PRO']['I_MD_BANNER_'.$l]['FILE_VALUE']['SRC']?>",
						 	"src3":"<?=$e['D_PRO']['I_SM_BANNER_'.$l]['FILE_VALUE']['SRC']?>"
						 }'
						 style="background-image: url('<?=$e['D_PRO']['I_LG_BANNER_'.$l]['FILE_VALUE']['SRC']?>')">
						<? if(count($arResult['ITEMS'])>1):?>
							<span class="swiper-lazy-preloader"></span>
						<? endif; ?>
					</div>
					<?if( $e['PRO']['I_LINK_'.$l]['VALUE'] )echo '</a>'?>
				</div>
			<?endforeach?>
		</div>
		<?if( count($arResult['ITEMS'])>1 ):?>
			<a class="jq_banner-left ipabs" href="#"></a>
			<a class="jq_banner-right ipabs" href="#"></a>
			<div class="jq_banner-pagination swiper-pagination ipabs"></div>
		<?endif?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
