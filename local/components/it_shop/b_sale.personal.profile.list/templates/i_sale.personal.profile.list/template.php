<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if(strlen($arResult["ERROR_MESSAGE"])>0)
{
	ShowError($arResult["ERROR_MESSAGE"]);
}
if(strlen($arResult["NAV_STRING"]) > 0)
{
	?>
	<p><?=$arResult["NAV_STRING"]?></p>
	<?
}

if (count($arResult["PROFILES"]))
{
	?>
	<div class="i_profile_list">
		<table class="table sale-personal-profile-list-container">
			<thead>
				<tr>
					<?
					$dataColumns = array(
						/*"ID", "DATE_UPDATE",*/ "NAME", "PERSON_TYPE", "DELIVERY"
					);
					foreach ($dataColumns as $column)
					{
						?>
						<td>
							<?=Loc::getMessage("P_".$column)?>
							<a class="sale-personal-profile-list-arrow-up" href="<?=$arResult['URL']?>by=<?=$column?>&order=asc#nav_start">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="sale-personal-profile-list-arrow-down" href="<?=$arResult['URL']?>by=<?=$column?>&order=desc#nav_start">
								<i class="fa fa-chevron-down"></i>
							</a>
						</td>
						<?
					}
					?>
					<td><?=Loc::getMessage("SALE_ACTION")?></td>
				</tr>
			</thead>
			<tbody>
				<?foreach($arResult["PROFILES"] as $val)
				{
					?>
					<tr>
						<?/*<td data-mess="<?=Loc::getMessage("P_ID")?>">
							<span>№<?= $val["ID"]?></span>
						</td>
						<td data-mess="<?=Loc::getMessage("P_DATE_UPDATE")?>">
							<span><?= $val["DATE_UPDATE"]?></span>
						</td>*/?>
						<td data-mess="<?=Loc::getMessage("P_NAME")?>" style="word-break: break-all;">
							<span><?= $val["NAME"]?></span>
						</td>
						<td data-mess="<?=Loc::getMessage("P_PERSON_TYPE")?>">
							<span><?= $val["PERSON_TYPE"]["NAME"]?></span>
						</td>
						<td data-mess="<?=Loc::getMessage("P_DELIVERY")?>">
							<span><?= $val["DELIVERY"]?></span>
						</td>
						<td class="sale-personal-profile-list-actions">
							<a class="sale-personal-profile-list-change-button" title="<?=Loc::getMessage("SALE_DETAIL_DESCR")?>"
								href="<?= $val["URL_TO_DETAIL"] ?>">
								<span><?=GetMessage("SALE_DETAIL")?></span>
							</a>
							<?/*<span class="sale-personal-profile-list-border"></span>*/?>
							<a class="sale-personal-profile-list-close-button" title="<?=Loc::getMessage("SALE_DELETE_DESCR")?>"
								href="javascript:if(confirm('<?= Loc::getMessage("STPPL_DELETE_CONFIRM") ?>')) window.location='<?= $val["URL_TO_DETELE"] ?>'">
								<span><?=Loc::getMessage("SALE_DELETE")?></span>
							</a>
						</td>
					</tr>
					<?
				}?>
			</tbody>
		</table>
	</div>
	<?
	if(strlen($arResult["NAV_STRING"]) > 0)
	{
		?>
		<p><?=$arResult["NAV_STRING"]?></p>
		<?
	}
}
else
{
	?>
	<h3><?=Loc::getMessage("STPPL_EMPTY_PROFILE_LIST") ?></h3>
	<?
}
?>





<?/*if($USER->isAdmin()):?>
	<pre>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>