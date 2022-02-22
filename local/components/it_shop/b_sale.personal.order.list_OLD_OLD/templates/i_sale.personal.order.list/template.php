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

			<a class="bx_mo_link i_mo_show_all<?if($nothing || $_REQUEST['filter_history'] == 'N')echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><span><?=GetMessage('SPOL_CUR_ORDERS')?></span></a>
			<a class="bx_mo_link i_mo_filt_y<?if($_REQUEST['filter_history'] == 'Y')echo ' i_mo_select'?>" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><span><?=GetMessage('SPOL_ORDERS_HISTORY')?></span></a>
		</div>

		<?if(!empty($arResult['ORDERS'])):?>

			<?foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

				<?foreach($group as $k => $order):?>

					<?if(!$k):?>
						<div class="bx_my_order_status_desc">
							<h3><?=GetMessage("SPOL_STATUS")?> <span class="<?=$arResult["INFO"]["STATUS"][$key]['COLOR']?>">"<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</span></h3>
							<div class="bx_mos_desc"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>
						</div>
					<?endif?>

					<div class="bx_my_order">

						<div class="bx_my_order_table">
							<div class="bx_my_order_table_head">
								<?=GetMessage('SPOL_ORDER')?> <?=GetMessage('SPOL_NUM_SIGN')?><?=$order["ORDER"]["ACCOUNT_NUMBER"]?>
								<?if(strlen($order["ORDER"]["DATE_INSERT_FORMATED"])):?>
									<?=GetMessage('SPOL_FROM')?> <?=$order["ORDER"]["DATE_INSERT_FORMATED"];?>
								<?endif?>
							</div>
							<div class="bx_my_order_table_body">
								<div class="bx_my_order_table_row">
									<div class="bx_my_order_table_col">
										<?=GetMessage('SPOL_PAY_SUM')?>:
									</div>
									<div class="bx_my_order_table_col">
										<b><?=$order["ORDER"]["FORMATED_PRICE"]?></b><div class="bx_my_order_status <?=$arResult['INFO']['STATUS'][$key]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?=$arResult['INFO']['STATUS'][$key]['NAME']?></div>
									</div>
								</div>
								<div class="bx_my_order_table_row">
									<div class="bx_my_order_table_col">
										<?=GetMessage('SPOL_PAYED')?>:
									</div>
									<div class="bx_my_order_table_col">
										<b><?=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?></b>
									</div>
								</div>

								<?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):// PAY SYSTEM ?>
									<div class="bx_my_order_table_row">
										<div class="bx_my_order_table_col">
											<?=GetMessage('SPOL_PAYSYSTEM')?>:
										</div>
										<div class="bx_my_order_table_col">
											<b><?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?></b>
										</div>
									</div>
								<?endif?>

								<?if($order['HAS_DELIVERY']):?>
									<div class="bx_my_order_table_row">
										<div class="bx_my_order_table_col">
											<?=GetMessage('SPOL_DELIVERY')?>:
										</div>
										<div class="bx_my_order_table_col">
											<b>
												<?if(intval($order["ORDER"]["DELIVERY_ID"])):?>
													<?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />
												<?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>
													<?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
													<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />
												<?endif?>
											</b>
										</div>
									</div>
								<?endif?>
							</div>
						</div>
						<?if(count($order["BASKET_ITEMS"])>0):?>
							<div class="i_comp_or_table">
								<div class="bx_my_order_table_head">
									<span><?=GetMessage('SPOL_BASKET')?>:</span>
								</div>
								<?foreach ($order["BASKET_ITEMS"] as $item):?>
									<div class="bx_my_order_table_row">
										<div class="bx_my_order_table_col">
											<?if(strlen($item["DETAIL_PAGE_URL"])):?>
											<a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
												<?endif?>
												<?=$item['NAME']?>
												<?if(strlen($item["DETAIL_PAGE_URL"])):?>
											</a>
										<?endif?>
										</div>
										<div class="bx_my_order_table_col">
											<nobr><?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></nobr>
										</div>
									</div>
								<?endforeach?>
							</div>
						<?endif?>

						<div class="i_or_butttom">
							<div class="bx_my_order_table_row">
								<div class="bx_my_order_table_col"><a class="i_but_ac i_but_ac_detail" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><span><?=GetMessage('SPOL_ORDER_DETAIL')?></span></a></div>
								<div class="bx_my_order_table_col">
									<?//=$order["ORDER"]["DATE_STATUS_FORMATED"]?>
									<?if($order["ORDER"]["CANCELED"] != "Y"):?>
										<a class="i_but_ac i_but_ac_cancel" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><span><?=GetMessage('SPOL_CANCEL_ORDER')?></span></a>
									<?endif?>
									<a class="i_but_ac i_but_ac_copy" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>" style="min-width:140px"class="bx_big bx_bt_button_type_2 bx_cart bx_order_action"><span><?=GetMessage('SPOL_REPEAT_ORDER')?></span></a>
								</div>
							</div>
						</div>
					</div>
				<?endforeach?>

			<?endforeach?>

			<?if(strlen($arResult['NAV_STRING'])):?>
				<?=$arResult['NAV_STRING']?>
			<?endif?>

		<?else:?>
			<div class="bx_my_order_switch_no"><?=GetMessage('SPOL_NO_ORDERS')?></div>
		<?endif?>

	<?endif?>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>