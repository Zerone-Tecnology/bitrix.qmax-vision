<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$sw = $arParams['I_SWIPE']?>
	<div class="i_item_wrap i_mt25">
		<div class="jq_pagination_<?=$sw?> lt-pagination ipabs"></div>
		<?if (!CSite::InDir(SITE_DIR.'catalog/')):?>
			<a class="i_h2" href="<?=$arParams['I_TITLE_LINK'];?>">
				<span><?=$arParams['I_TITLE']?></span>
			</a>
		<?else:?>
			<span class="i_h2" href="<?=$arParams['I_TITLE_LINK'];?>">
				<span><?=$arParams['I_TITLE']?></span>
			</span>
		<?endif;?>
		<? $arParams['LAZY_LOAD'] = 'Y';?>
		<div class="i_sblock jq_sblock_<?=$sw?> swiper-container<?if( CSite::InDir(SITE_DIR.'index.php') && $arParams['I_IWIDE_BLOCK']!='Y' )echo ' i_sblock_index'?>">
			<div class="swiper-wrapper">
				<?foreach($arResult['ITEMS'] as $k=>$e):
					$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
					<div class="swiper-slide">
						<?i_showItem($APPLICATION, array('I_BASE_CURRENCY'=>$arResult['I_BASE_CURRENCY'], 'EDIT'=>$this->GetEditAreaId($e['ID']), 'FROM'=>'CATALOG_SECTION'), $e, $arParams, $arResult['CAT_PRICES']);// path of function - /local/templates/ilab_it_shop/tmpl/php/item.php?>
					</div>
				<?endforeach?>
			</div>
		</div>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>

<?
// JQ prefix
$sw = $arParams['I_SWIPE'];?>

<script>
	$(document).ready(function(){
		var <?=$sw?>Swiper = new Swiper('.jq_sblock_<?=$sw?>',
		{
			grabCursor: true,
			slidesPerView: 6,

			preloadImages: false,
			lazy: true,

			pagination: {
				el: $('.jq_pagination_<?=$sw?>'),
				dynamicBullets: true,
//              type: 'bullets',// "bullets", "fraction", "progressbar" or "custom"
				clickable: true,
			},

		breakpoints: {
				440: {
					slidesPerView: 1
				},
				560: {
					slidesPerView: 2
				},
				780: {
					slidesPerView: 3
				},
				960: {
					slidesPerView: 4
				},
				1200: {
					slidesPerView: 5
				},
				1300: {
					slidesPerView: 5
				}
			},

			on: {
				touchStart: function (swiper) {
					$('.i_item_wrap').addClass('wrap-selected');
					$('.i_item').addClass('item-selected');
				},
				transitionEnd: function (swiper) {
					$('.i_item_wrap').removeClass('wrap-selected');
					$('.i_item').removeClass('item-selected');
					i_hide_sblock_stickers();
				},
				init: function () {
					i_hide_sblock_stickers();
				}
			}
		});

	});
</script>
<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><? print_r($arResult['ITEMS'][0])?></pre>
<?endif*/?>
