<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>
	<div class="i_lmenu_link jq_lmenu_link idnone">
		<div class="i_lmenu_link_wrap iprel">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
	<div class="i_lmenu">
	<ul>
	<?$previousLevel = 0;
	foreach($arResult as $arItem):?>
		<?if ($previousLevel && $arItem['DEPTH_LEVEL'] < $previousLevel)
			echo str_repeat('</ul></li>', ($previousLevel - $arItem['DEPTH_LEVEL']))?>

		<?if ($arItem['IS_PARENT']):?>
				<li class="jq_lmenu_li_1<?if($arItem['CHILD_SELECTED'] !== true)echo ' i_lmenu_close'?>">
					<div class="item-text"><a href="<?=$arItem['LINK']?>" class="jq_lmenu_a i_lmore<?if($arItem['CHILD_SELECTED'] !== true)echo ' i_lmore';//if($arItem['SELECTED'])echo ' i_lmenu_activ'?>"><?=$arItem['TEXT']?></a></div>
					<ul class="i_lmenu_ul_<?echo ++$arItem['DEPTH_LEVEL']?>">

		<?else:?>

			<?if ($arItem['PERMISSION'] > 'D'):?>
					<li>
						<div class="item-text"><a <?if($arItem['SELECTED'])echo 'class="i_lmenu_activ" '?>href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></div>
					</li>
			<?endif?>

		<?endif?>

		<?$previousLevel = $arItem['DEPTH_LEVEL'];?>

	<?endforeach?>

	<?if ($previousLevel > 1)//close last item tags
		echo str_repeat('</ul></li>', ($previousLevel-1))?>

	</ul>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>