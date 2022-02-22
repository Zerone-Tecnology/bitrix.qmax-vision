<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);

// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
	$count = count($arResult['ITEMS']);
	?>
	<div class="i_cl_bl_wrap i_cl_bl_wrap_<?=$count?> j_cl_bl_swiper swiper-container">
		<div class="swiper-wrapper">
			<? foreach($arResult['ITEMS'] as $key=>$arItem): ?>
			<?if($key==1):?>
					<div class="i_cl_bl_el swiper-slide i_cl_bl_block_<?=$key?>">
						<a class="" href="<?=$arItem['I_LINK']?>">
							<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
								<img class="i_cl_bl_el_img" src="<?if($arItem['DETAIL_PICTURE']):?><?=$arItem['DETAIL_PICTURE']?><?endif;?>" alt="<?=$arItem['NAME']?>">
								<span class="i_cl_bl_el_wr"><?=$arItem['NAME']?> </span>
							</div>
						</a>
					</div>
			<?endif?>
				<?if($key==2):?>
					<div class="i_cl_bl_el swiper-slide i_cl_bl_block_<?=$key?>">
						<a class="" href="<?=$arItem['I_LINK']?>">
							<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
								<img class="i_cl_bl_el_img" src="<?if($arItem['PREVIEW_PICTURE']):?><?=$arItem['PREVIEW_PICTURE']?><?endif;?>" alt="<?=$arItem['NAME']?>">
								<span class="i_cl_bl_el_wr"><?=$arItem['NAME']?> </span>
							</div>
						</a>
						<a class="" href="<?=$arResult['ITEMS'][4]['I_LINK']?>">
							<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
								<img class="i_cl_bl_el_img" src="<?if($arResult['ITEMS'][4]['PREVIEW_PICTURE']):?><?=$arResult['ITEMS'][4]['PREVIEW_PICTURE']?><?endif;?>" alt="<?=$arResult['ITEMS'][4]['NAME']?>">
								<span class="i_cl_bl_el_wr"><?=$arResult['ITEMS'][4]['NAME']?> </span>
							</div>
						</a>
					</div>
				<?endif?>
			<?if($key==3):?>
				<div class="i_cl_bl_el swiper-slide i_cl_bl_block_<?=$key?>">
					<a class="" href="<?=$arResult['ITEMS'][0]['I_LINK']?>">
						<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
							<img class="i_cl_bl_el_img" src="<?if($arResult['ITEMS'][0]['PREVIEW_PICTURE']):?><?=$arResult['ITEMS'][0]['PREVIEW_PICTURE']?><?endif;?>" alt="<?=$arResult['ITEMS'][0]['NAME']?>">
							<span class="i_cl_bl_el_wr"><?=$arResult['ITEMS'][0]['NAME']?> </span>
						</div>
					</a>
					<a class="" href="<?=$arItem['I_LINK']?>">
						<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
							<img class="i_cl_bl_el_img" src="<?if($arItem['PREVIEW_PICTURE']):?><?=$arItem['PREVIEW_PICTURE']?><?endif;?>" alt="<?=$arItem['NAME']?>">
							<span class="i_cl_bl_el_wr"><?=$arItem['NAME']?> </span>
						</div>
					</a>
				</div>
			<?endif?>
			<div class="i_cl_bl_el swiper-slide i_cl_bl_el_<?=$key?> idn">
				<a class="" href="<?=$arItem['I_LINK']?>">
					<div class="i_cl_bl_el_cont i_cl_bl_el_cont_1">
						<img class="i_cl_bl_el_img" src="<?if($arItem['PREVIEW_PICTURE']):?><?=$arItem['PREVIEW_PICTURE']?><?endif;?>" alt="<?=$arItem['NAME']?>">
						<span class="i_cl_bl_el_wr"><?=$arItem['NAME']?> </span>
					</div>
					<div class="idnone i_cl_bl_el_cont i_cl_bl_el_cont_2">
						<img class='i_cl_bl_el_img' src="<?if($arItem['DETAIL_PICTURE']):?><?=$arItem['DETAIL_PICTURE']?><?endif;?>" alt="<?=$arItem['NAME']?>">
						<span class="i_cl_bl_el_wr"><?=$arItem['NAME']?> </span>
					</div>
				</a>
			</div>
			<? endforeach; ?>
		</div>
	</div>

	<script>
		var cat_links_sw = new Swiper('.j_cl_bl_swiper', {
			grabCursor: true,
			slidesPerView: 'auto',
			/*slidesPerColumn: 2,
			slidesPerColumnFill: 'column',*/

			preloadImages: false,
			lazy: true,

			freeMode: true,
			resistance: true,
			resistanceRatio: 0,
		});
	</script>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?/*if($USER->isAdmin()):?>
	<pre CLASS="ipre"><?print_r($arItem)?></pre>
<?endif?>
