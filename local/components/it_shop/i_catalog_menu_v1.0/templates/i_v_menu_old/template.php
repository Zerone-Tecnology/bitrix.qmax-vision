<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/* Иногда лучше остаться спать дома в понедельник, чем провести всю неделю отлаживая написанный в понедельник код. */
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>


<?function i_view_cat($data)
{
	foreach ($data as $menu):
		$DL = $menu['DEPTH_LEVEL']?>

		<div class="i_vmenu_div_<?=$DL?>">

			<a href="<?=$menu['SECTION_PAGE_URL']?>" class="i_vmenu_a_<?=$DL;if($DL==1 && $menu['I_CHILD'])echo ' i_vmenu_arrow jq_vmenu_arrow'?>"><?=$menu['NAME']?></a>

			<?if($menu['I_CHILD']):?>
				<div class="i_vsub_<?=$DL?> jq_vsub_<?=$DL;if($DL==1)echo ' ivhid'?>">
					<?if($DL==1)echo '<div class="jq_shapeshift iprel">'?>
						<?i_view_cat($menu['I_CHILD'])?>
					<?if($DL==1)echo '</div>'?>
				</div>
			<?endif?>

		</div>
	<?endforeach;
}?>

<nav class="i_vmenu iprel">
	<div class="i_vmenu_catalog iprel ifont110"><?=GetMessage('CATALOG')?></div>
	<div class="i_vmenu_in">
		<?i_view_cat($arResult['ITEMS'])?>
	</div>
</nav>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arParams)?></pre>
<?endif*/?>