<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);

// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
	$count = count($arResult['ITEMS']);
	?>
    <div class="i_partners-container swiper-container">
        <div class="i_partners-wrapper swiper-wrapper">
			<? foreach($arResult['ITEMS'] as $arItem): ?>
                <div class="i_partners-slide swiper-slide">
                    <a href="<?=$arItem['PRO']['I_LINK_'.$l]['VALUE']?>"><div class="i_partner_img" style="background-image: url(<?=$arItem['PREVIEW_PICTURE']?>)"></div></a>
                </div>
			<? endforeach; ?>
        </div>
        <div class="i_partners-button-prev swiper-button-prev"></div>
        <div class="i_partners-button-next swiper-button-next"></div>
    </div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
<script>
    $(document).ready(function(){
        if($('.i_partners-container').length)
        {
            var SwiperPartners = new Swiper('.i_partners-container', {
                wrapperClass: 'i_partners-wrapper',
				navigation: {
					nextEl: $('.i_partners-button-next'),
					prevEl: $('.i_partners-button-prev')
				},
                slidesPerView: 6,
                spaceBetween: 10,
                paginationClickable: true,
                loop: true,
                breakpoints: {
                    480: {
                        slidesPerView: 1
                    },
                    640: {
                        slidesPerView: 2
                    },
                    960: {
                        slidesPerView: 3

                    },
                    1024: {
                        slidesPerView: 4
                    },
                    1280: {
                        slidesPerView: 5
                    }
                }
            });
        }
    });

</script>
