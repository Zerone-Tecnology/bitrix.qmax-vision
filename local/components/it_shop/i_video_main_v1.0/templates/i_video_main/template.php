<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
$l = strtoupper(LANGUAGE_ID);
if($arResult['ITEMS']):?>
	<h2><a class="i_h2" href="/video_sw/"><?=GetMessage('VIDEO')?></a></h2>
	<div class="i_video_block swiper-container">
		<div class="i_vb_wrapper swiper-wrapper">
			<?foreach($arResult['ITEMS'] as $e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
				<?if( $e['PRO']['I_VIDEO_RU']['VALUE'] ):?>
					<a href="/<?=$e['IBLOCK_CODE']?>/<?=$e['CODE']?>/" class="i_vb_ele swiper-slide" id="<?=$this->GetEditAreaId($e['ID']);?>">
						<?if( $e['PRO']['I_IMG_'.$l]['VALUE'] ):?>
							<div class="i_vb_img" style="background-image: url(<?=CFile::GetPath($e['PRO']['I_IMG_'.$l]['VALUE'])?>)"></div>
						<?endif?>
						<div class="i_vb_title">
							<p class="i_vb_name"><?=$e['NAME']?></p>
						</div>
					</a>
				<?endif?>
			<?endforeach?>
		</div>
		<div class="i_vb-prev swiper-button-prev"></div>
		<div class="i_vb-next swiper-button-next"></div>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


	<script>
		$(document).ready(function(){
			if($('.i_video_block').length)
			{
				var SwiperPartners = new Swiper('.i_video_block',
				{
					grabCursor: true,
					slidesPerView: 5,
					spaceBetween: 1,

					navigation: {
						nextEl: $('.i_vb-next'),
						prevEl: $('.i_vb-prev')
					},

					loop: true,

					breakpoints: {
						460: {
							slidesPerView: 1
						},
						740: {
							slidesPerView: 2
						},
						960: {
							slidesPerView: 3

						},
						1024: {
							slidesPerView: 4
						},
						1280: {
							slidesPerView: 4
						}
					}
				});
			}
		});
	</script>


<?/*if($USER->isAdmin()):?>
	<pre class="ipre">
		<?//print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>