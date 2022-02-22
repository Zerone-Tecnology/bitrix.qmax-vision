<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>

	<?if(!empty($arResult['ERRORS']['FATAL'])):?>

		<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?else:?>

		<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

			<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
				<?=ShowError($error)?>
			<?endforeach?>

		<?endif?>

		<div class="bx_my_order_switch">

			<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

	<?/*
			<?if($nothing || isset($_REQUEST["filter_history"])):?>
				<a class="bx_mo_link i_mo_show_all ifleft<?if($_REQUEST["show_all"] || $nothing)echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><span><?=GetMessage('SPOL_ORDERS_ALL')?></span></a>
			<?endif?>

			<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
				<a class="bx_mo_link i_mo_filt_n ifleft i_mo_select" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><span><?=GetMessage('SPOL_CUR_ORDERS')?></span></a>
			<?endif?>

			<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
				<a class="bx_mo_link i_mo_filt_y ifleft<?if($_REQUEST['filter_history'] == 'Y')echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><span><?=GetMessage('SPOL_ORDERS_HISTORY')?></span></a>
			<?endif?>
	*/?>

			<a class="bx_mo_link i_mo_show_all ifleft<?if($nothing || $_REQUEST['filter_history'] == 'N')echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><span><?=GetMessage('SPOL_CUR_ORDERS')?></span></a>
			<a class="bx_mo_link i_mo_filt_y ifleft<?if($_REQUEST['filter_history'] == 'Y')echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><span><?=GetMessage('SPOL_ORDERS_HISTORY')?></span></a>
			<div class="iclear"></div>

		</div>

		<?if(!empty($arResult['ORDERS'])):?>

			<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

				<?foreach($group as $k => $order):?>

					<?if(!$k):?>
						<div class="bx_my_order_status_desc">
							<h3><?=GetMessage("SPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h3>
							<div class="bx_mos_desc"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>
						</div>
					<?endif?>

					<div class="bx_my_order">
						
						<table class="bx_my_order_table">
							<thead>
								<tr>
									<td colspan="2">
										<h3><?=GetMessage('SPOL_ORDER')?> <?=GetMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?></h3>
										<?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
											<?=GetMessage('SPOL_FROM')?> <?=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
										<?endif?>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="190px">
										<?=GetMessage('SPOL_PAY_SUM')?>:
									</td>
									<td>
										<b><?=$order["ORDER"]["FORMATED_PRICE"]?></b><div class="bx_my_order_status <?=$arResult['INFO']['STATUS'][$key]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?=$arResult['INFO']['STATUS'][$key]['NAME']?></div>
									</td>
								</tr>
								<tr>
									<td>
										<?=GetMessage('SPOL_PAYED')?>:
									</td>
									<td>
										<b><?=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?></b>
									</td>
								</tr>

								<?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):// PAY SYSTEM ?>
									<tr>
										<td>
											<?=GetMessage('SPOL_PAYSYSTEM')?>:
										</td>
										<td>
											<b><?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?></b>
										</td>
									</tr>
								<?endif?>
								
								<?if($order['HAS_DELIVERY']):?>
									<tr>
										<td>
											<?=GetMessage('SPOL_DELIVERY')?>:
										</td>
										<td>
											<b>
												<?if(intval($order["ORDER"]["DELIVERY_ID"])):?>
													<?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />
												<?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>
													<?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
													<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />
												<?endif?>
											</b>
										</td>
									</tr>
								<?endif?>
							</tbody>
						</table>
						<table class="i_comp_or_table">
								<tr>
									<td class="i_comp_or" colspan="2">
										<?=GetMessage('SPOL_BASKET')?>:
									</td>
								</tr>
								<?foreach ($order["BASKET_ITEMS"] as $item):?>
									<tr>
										<td class="ifont120">
											<?if(strlen($item["DETAIL_PAGE_URL"])):?>
												<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
											<?endif?>
												<?=$item['NAME']?>
											<?if(strlen($item["DETAIL_PAGE_URL"])):?>
												</a> 
											<?endif?>
										</td>
										<td width="100px">
											<nobr><?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></nobr>
										</td>
									</tr>
								<?endforeach?>
						</table>
							
						<div class="i_or_butttom">
							<a class="i_but_ac ifleft" href="<?=$order["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage('SPOL_ORDER_DETAIL')?></a>
							<?//=$order["ORDER"]["DATE_STATUS_FORMATED"]?>
							<div class="ifright">
								<?if($order["ORDER"]["CANCELED"] != "Y"):?>
									<a class="i_but_ac" href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?=GetMessage('SPOL_CANCEL_ORDER')?></a>
								<?endif?>
								<a class="i_but_ac" href="<?=$order["ORDER"]["URL_TO_COPY"]?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><?=GetMessage('SPOL_REPEAT_ORDER')?></a>
							</div>
							<div class="iclear"></div>
						</div>

					</div>

				<?endforeach?>

			<?endforeach?>

			<?if(strlen($arResult['NAV_STRING'])):?>
				<?=$arResult['NAV_STRING']?>
			<?endif?>

		<?else:?>
			<br><br><?=GetMessage('SPOL_NO_ORDERS')?>
		<?endif?>

	<?endif?>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>