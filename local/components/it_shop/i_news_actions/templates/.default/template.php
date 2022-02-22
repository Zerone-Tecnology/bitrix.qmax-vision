<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
$l = strtoupper(LANGUAGE_ID);
?>

<? if($arResult['ITEMS']): ?>
	<div class="i_actions_news_wide_content<?=' '.$arResult['COUNT']?>">
		<? $s = 1; foreach($arResult['ITEMS'] as $key=> $arCol): ?>
			<? if($key == 7): ?>
				<div class="i_news_wide elem<?=count($arResult['ITEMS'][$key])?> block<?=$s?>">
					<a href="/news/" class="i_h2">
						<? if($arParams['I_NAME_NEWS_'.$l]): ?>
							<span><?=$arParams['I_NAME_NEWS_'.$l];?></span>
						<? else: ?>
							<span><?=GetMessage('NEWS');?></span>
						<? endif; ?>
					</a>
					<div class="i_actions_news_wide_wrap">
						<div class="i_actions_news_wide_cont">
							<? foreach($arCol as $key=>$arItem): ?>
								<div class="i_actions_news_wide_item">
									<div class="i_actions_news_wide_item_cont">
										<?if($arItem['PREVIEW_PICTURE_SRC']):?>
											<a class="i_actions_news_wide_img" href="<?=$arItem['DETAIL_PAGE_URL']?>"
											   style="background-image: url(<?=$arItem['PREVIEW_PICTURE_SRC'];?>)"></a>
										<?else:?>
											<a class="i_actions_news_wide_img" href="<?=$arItem['DETAIL_PAGE_URL']?>"
											   style="background-image: url(<?=$arItem['PREVIEW_PICTURE_SRC'];?>)"></a>
										<?endif;?>
										<?if($arItem['DISPLAY_ACTIVE_FROM']):
//											код для замены формата времqни
											$arr = ParseDateTime($arItem["DISPLAY_ACTIVE_FROM"], FORMAT_DATETIME);
											$arItem["DISPLAY_ACTIVE_FROM"] = $arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
											<div class="i_actions_news_wide_date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>
										<?endif;?>
										<?if($arItem['NAME']):?>
											<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="i_actions_news_wide_name">
												<?=$arItem['NAME'];?></a>
										<?endif;?>
										<?if($arItem['PREVIEW_TEXT']):?>
											<div class="i_actions_news_wide_text"><?=$arItem['PREVIEW_TEXT'];?></div>
										<?endif;?>
									</div>
								</div>
							<? endforeach; ?>
						</div>
						<div class="i_news_actions_all">
							<a href="/news/"><span><?=GetMessage('ALL_NEWS');?></span></a>
						</div>
					</div>
				</div>
			<? endif; ?>
			<? if($key == 6): ?>
				<div class="i_actions_wide elem<?=count($arResult['ITEMS'][$key])?> block<?=$s?>">
					<a href="/action/" class="i_h2">
						<? if($arParams['I_NAME_ACTIONS_'.$l]): ?>
							<span><?=$arParams['I_NAME_ACTIONS_'.$l];?></span>
						<? else: ?>
							<span><?=GetMessage('ACTIONS');?></span>
						<? endif; ?>
					</a>
					<div class="i_actions_news_wide_wrap">
						<div class="i_actions_news_wide_cont">
							<? foreach($arCol as $key=>$arItem): ?>
								<div class="i_actions_news_wide_item">
									<div class="i_actions_news_wide_item_cont">
										<?if($arItem['PREVIEW_PICTURE_SRC']):?>
											<a class="i_actions_news_wide_img" href="<?=$arItem['DETAIL_PAGE_URL']?>"
											   style="background-image: url(<?=$arItem['PREVIEW_PICTURE_SRC'];?>)"></a>
										<?else:?>
											<a class="i_actions_news_wide_img" href="<?=$arItem['DETAIL_PAGE_URL']?>"
											   style="background-image: url(<?=$arItem['PREVIEW_PICTURE_SRC'];?>)"></a>
										<?endif;?>
										<?if($arItem['DISPLAY_ACTIVE_FROM']):
//                                            код для замены формата времqни
											$arr = ParseDateTime($arItem["DISPLAY_ACTIVE_FROM"], FORMAT_DATETIME);
											$arItem["DISPLAY_ACTIVE_FROM"] = $arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
											<div class="i_actions_news_wide_date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></div>
                                        <?/*
                                            $arr = ParseDateTime($arItem["DISPLAY_ACTIVE_FROM"], FORMAT_DATETIME);
                                            $arItem["DISPLAY_ACTIVE_FROM"] = $arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];

                                        */?>

										<?endif;?>
										<?if($arItem['NAME']):?>
											<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="i_actions_news_wide_name">
												<?=$arItem['NAME'];?></a>
										<?endif;?>
										<?if($arItem['PREVIEW_TEXT']):?>
											<div class="i_actions_news_wide_text"><?=$arItem['PREVIEW_TEXT'];?></div>
										<?endif;?>
									</div>
								</div>
							<? endforeach; ?>
						</div>
						<div class="i_news_actions_all">
							<a href="/action/"><span><?=GetMessage('ALL_ACTIONS');?></span></a>
						</div>
					</div>
				</div>
			<? endif; ?>
			<? $s++; endforeach; ?>
	</div>
<? endif; ?>

<?/*if($USER->IsAdmin()):?>
 <pre class="ipre"><?print_r($arResult);?></pre>
<?endif*/?>
