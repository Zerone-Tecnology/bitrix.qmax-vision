<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/local/components/it_shop/b_sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/local/components/it_shop/b_sale.order.payment.change/templates/.default/style.css");
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);?>

<div class="i_sale_order_list">

<?if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			ShowError($error);
		}
	}?>
	<div class="sale-order-history">
		<?
		$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
		$clearFromLink = array("filter_history","filter_status","show_all", "show_canceled");


//		if ($_REQUEST["filter_history"] == 'Y')
//		{
			?>
			<a class="sale-order-history-link i_current<?if( $nothing )echo ' i_ol_look_selected'?>" href="<?=$APPLICATION->GetCurPageParam("", $clearFromLink, false)?>">
				<?echo Loc::getMessage("SPOL_TPL_CUR_ORDERS")?>
			</a>
			<?/*
			if ($_REQUEST["show_canceled"] == 'Y')
			{
				?>
				<a class="sale-order-history-link" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>">
					<?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?>
				</a>
				<?
			}
			else
			{
				?>
				<a class="sale-order-history-link" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false)?>">
					<?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED")?>
				</a>
				<?
			}*/
//		}
//		if ($nothing || $_REQUEST["filter_history"] == 'N')
//		{
			?>
			<a class="sale-order-history-link i_history<?if( $_REQUEST["filter_history"] == 'Y' && !$_REQUEST['show_canceled'] )echo ' i_ol_look_selected'?>" href="<?=$APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false)?>">
				<?echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY")?>
			</a>
			<?
//		}?>
	</div>
	<?
	if (!count($arResult['ORDERS']))
	{
		if ($_REQUEST["filter_history"] == 'Y')
		{
			if ($_REQUEST["show_canceled"] == 'Y')
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER')?></h3>
				<?
			}
			else
			{
				?>
				<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST')?></h3>
				<?
			}
		}
		else
		{
			?>
			<h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST')?></h3>
			<?
		}
	}
	if (!count($arResult['ORDERS']))
	{
		?>
		<div class="">
			<a href="<?=htmlspecialcharsbx($arParams['PATH_TO_CATALOG'])?>" class="sale-order-link-to-catalog">
				<?=Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG')?>
			</a>
		</div>
		<?
	}

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$paymentChangeData = array();
		$orderHeaderStatus = null;

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];

				?>
				<h1 class="sale-order-title">
					<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
				</h1>
				<?
			}
			?>
			<div class="sale-order-list-container">
				<div class="sale-order-list-title-container">
					<h2 class="sale-order-list-title">
						<?=Loc::getMessage('SPOL_TPL_ORDER')?>
						<?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
						<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
						<?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])/*?>,
						<?=count($order['BASKET_ITEMS']);?>
						<?
						$count = count($order['BASKET_ITEMS']) % 10;
						if ($count == '1')
						{
							echo Loc::getMessage('SPOL_TPL_GOOD');
						}
						elseif ($count >= '2' && $count <= '4')
						{
							echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
						}
						else
						{
							echo Loc::getMessage('SPOL_TPL_GOODS');
						}
						?>
						<?=Loc::getMessage('SPOL_TPL_SUMOF')?>
						<?=$order['ORDER']['FORMATED_PRICE']*/?>
					</h2>
				</div>
				<div class="sale-order-list-inner-container">
					<div class="sale-order-list-inner-title-line">
						<b><?echo GetMessage("SPOD_NAME")?></b>
						<b><?echo GetMessage("SPOD_PRICE")?></b>
						<b><?echo GetMessage("SPOD_QUANTITY")?></b>
						<b><?echo GetMessage("SPOD_ORDER_PRICE")?></b>
					</div>
					<div class="sale_personal_order_list">
						<?
							foreach ($order["BASKET_ITEMS"] as $item)
							{
								$measure = (isset($item["MEASURE_TEXT"])) ? $item["MEASURE_TEXT"] :GetMessage("STPOL_SHT");
								?>
								<div class="sale_personal_order_list_item">
									<div class="sale_personal_order_list_box">
										<span class="idn"><?echo GetMessage("SPOD_NAME")?>:</span>
										<div class="sale_personal_order_list_img">
											<img src="<?=($item['PICTURE']) ? $item['PICTURE'] : SITE_TEMPLATE_PATH . '/ilab/img/nophoto.png'?>" alt="<?=$item["NAME"]?>">
										</div>
										<div class="sale_personal_order_list_name">
											<?
												if (strlen($item["DETAIL_PAGE_URL"]) > 0)
													echo '<a href="'.$item["DETAIL_PAGE_URL"].'">';
												echo $item["NAME"];
												if (strlen($item["DETAIL_PAGE_URL"]) > 0)
													echo '</a>';
											?>
										</div>
									</div>
									<div class="sale_personal_order_list_price">
										<span class="idn"><?echo GetMessage("SPOD_PRICE")?>:</span>
										<?if ($item['DISCOUNT_PRICE'] >= 1):?>
											<div class="sale_personal_order_list_price_discount_container">
												<span class="sale_personal_order_list_base_price"><?=round($item["BASE_PRICE"])?> тг.</span>
												<b><?=round($item["PRICE"])?> тг.</b>
											</div>
										<?else:?>
											<b><?=round($item["PRICE"])?> тг.</b>
										<?endif;?>
									</div>
									<div class="sale_personal_order_list_quantity">
										<span class="idn"><?echo GetMessage("SPOD_QUANTITY")?>:</span>
										<b><?=$item["QUANTITY"] ?> <?=$measure?></b>
									</div>
									<div class="sale_personal_order_list_total">
										<span class="idn"><?echo GetMessage("SPOD_ORDER_PRICE")?>:</span>
										<b><?=$item["PRICE"] * $item["QUANTITY"]?> тг.</b>
									</div>
								</div>
								<?
							}
						?>
					</div>
					<?/*<div class="sale-order-list-inner-title-line">
						<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></span>
					</div>*/?>
					<?
					$showDelimeter = false;
					foreach ($order['PAYMENT'] as $payment)
					{
						if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
						{
							$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
								"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
								"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
								"allow_inner" => $arParams['ALLOW_INNER'],
								"only_inner_full" => $arParams['ONLY_INNER_FULL']
							);
						}
						?>
						<div class="sale-order-list-inner-row">
							<?
							if ($showDelimeter)
							{
								?>
								<div class="sale-order-list-top-border"></div>
								<?
							}
							else
							{
								$showDelimeter = true;
							}
							?>

							<div class="sale-order-list-inner-row-body">
								<div class="sale-order-list-payment">
									<?/*<div class="sale-order-list-payment-title">
										<?
										/*$paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL')." ".Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
										if(isset($payment['DATE_BILL']))
										{
											$paymentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
										}
										$paymentSubTitle .=",";*//*
										echo $paymentSubTitle;
										?>
										<span class="sale-order-list-payment-title-element"><?=$payment['PAY_SYSTEM_NAME']?>:</span>
									</div>*/?>
									<div class="sale-order-list-payment-price">
										<span class="sale-order-list-payment-element"><?=Loc::getMessage('SPOL_TPL_SUM_TO_PAID')?>:</span>
										<div class="sale-order-list-payment-status-box">
											<span class="sale-order-list-payment-number"><?=$payment['FORMATED_SUM']?></span>
											<?
												if ($payment['PAID'] === 'Y')
												{
													?>
													<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
													<?
												}
												elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
												{
													?>
													<span class="sale-order-list-status-restricted"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></span>
													<?
												}
												else
												{
													?>
													<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></span>
													<?
												}
											?>
										</div>
									</div>
									<div class="sale-order-list-payment-pay-check-box">
										<span class="sale-order-list-payment-pay-check-title"><?=Loc::getMessage('SPOL_PAYED')?>:</span>
										<?if($payment['PAID'] == 'Y'):?>
											<b class="sale-order-list-payment-pay-check"><?=Loc::getMessage('SPOL_YES')?></b>
										<?else:?>
											<b class="sale-order-list-payment-pay-check"><?=Loc::getMessage('SPOL_NO')?></b>
										<?endif;?>
									</div>
									<div class="sale-order-list-payment-name-box">
										<span class="sale-order-list-payment-name-title"><?=Loc::getMessage('SPOL_PAYSYSTEM')?>:</span>
										<b class="sale-order-list-payment-name"><?=$payment['PAY_SYSTEM_NAME']?></b>
									</div>
									<?
									if (!empty($payment['CHECK_DATA']))
									{
										$listCheckLinks = "";
										foreach ($payment['CHECK_DATA'] as $checkInfo)
										{
											$title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
											if (strlen($checkInfo['LINK']))
											{
												$link = $checkInfo['LINK'];
												$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
											}
										}
										if (strlen($listCheckLinks) > 0)
										{
											?>
											<div class="sale-order-list-payment-check">
												<div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE')?>:</div>
												<div class="sale-order-list-payment-check-left">
													<?=$listCheckLinks?>
												</div>
											</div>
											<?
										}
									}
									if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y')
									{
										?>
										<div class="sale-order-list-status-restricted-message-block">
											<span class="sale-order-list-status-restricted-message"><?=Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE')?></span>
										</div>
										<?
									}
									?>

								</div>
								<?/*if(
									$payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y'
									||
									$payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
								):?>
									<div class="sale-order-list-button-container">
										<?
										if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y')
										{
											if ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
											{
												?>
												<a class="sale-order-list-button inactive-button">
													<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
												</a>
												<?
											}
											elseif ($payment['NEW_WINDOW'] === 'Y')
											{
												?>
											
												<a class="sale-order-list-button" target="_blank" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
													<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
												</a>
												<?
											}
											else
											{
												?>
												<a class="sale-order-list-button ajax_reload" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
													<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
												</a>
												<?
											}
										}
										if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
										{
											?>
											<a href="#" class="sale-order-list-change-payment" id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>">
												<span id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>"><?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?></span>
											</a>
											<?
										}
										?>
									</div>
								<?endif*/?>
							</div>
							<div class="sale-order-list-inner-row-template">
								<a class="sale-order-list-cancel-payment">
									<i class=""></i> <?=Loc::getMessage('SPOL_CANCEL_PAYMENT')?>
								</a>
							</div>
						</div>
						<?
					}
					if (!empty($order['SHIPMENT']))
					{
						?>
						<?/*<div class="sale-order-list-inner-title-line">
							<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></span>
						</div>*/?>
						<?
					}
					$showDelimeter = false;
					foreach ($order['SHIPMENT'] as $shipment)
					{
						if (empty($shipment))
						{
							continue;
						}
						?>
						<div class="sale-order-list-inner-row">
							<?
								if ($showDelimeter)
								{
									?>
									<div class="sale-order-list-top-border"></div>
									<?
								}
								else
								{
									$showDelimeter = true;
								}
							?>
							<div class="sale-order-list-shipment">
								<?/*<div class="sale-order-list-shipment-title">
									<span class="sale-order-list-shipment-element">
										<?/*=Loc::getMessage('SPOL_TPL_LOAD')?>
										<?
										$shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
										if ($shipment['DATE_DEDUCTED'])
										{
											$shipmentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$shipment['DATE_DEDUCTED']->format($arParams['ACTIVE_DATE_FORMAT']);
										}

										if ($shipment['FORMATED_DELIVERY_PRICE'])
										{
											$shipmentSubTitle .= ", ".Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];
										}*//*
										$shipmentSubTitle = Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];

										echo $shipmentSubTitle;
										?>:
									</span>
									<?
									if ($shipment['DEDUCTED'] == 'Y')
									{
										?>
										<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_LOADED');?></span>
										<?
									}
									else
									{
										?>
										<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTLOADED');?></span>
										<?
									}
									?>
								</div>

								<div class="sale-order-list-shipment-status">
									<span class="sale-order-list-shipment-status-item"><?=Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS');?>:</span>
									<span class="sale-order-list-shipment-status-block sale-order-list-<?=($shipment['STATUS_ID']=='DF') ? 'green' : 'orange'?>"><?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?></span>
								</div>*/?>

								<?
								if (!empty($shipment['DELIVERY_ID']))
								{
									?>
									<div class="sale-order-list-shipment-item">
										<span class="sale-order-list-shipment-item-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?>:</span>
										<span class="sale-order-list-shipment-item-block"><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"])?><?//=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?></span>
									</div>
									<?
								}

								if (!empty($shipment['TRACKING_NUMBER']))
								{
									?>
									<div class="sale-order-list-shipment-item">
										<span class="sale-order-list-shipment-id-name"><?=Loc::getMessage('SPOL_TPL_POSTID')?>:</span>
										<span class="sale-order-list-shipment-id"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
										<span class="sale-order-list-shipment-id-icon"></span>
									</div>
									<?
								}
								?>
							</div>
							<?
							if (strlen($shipment['TRACKING_URL']) > 0)
							{
								?>
								<div class="sale-order-list-shipment-button-container">
									<a class="sale-order-list-shipment-button" target="_blank" href="<?=$shipment['TRACKING_URL']?>">
										<?=Loc::getMessage('SPOL_TPL_CHECK_POSTID')?>
									</a>
								</div>
								<?
							}
							?>
						</div>
						<?
					}
					?>

					<div class="sale-order-list-inner-row sale-order-list-url-container">
						<div class="sale-order-list-about-container">
							<a class="sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><span><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></span></a>
						</div>
						<div class="sale-order-list-repeat-container">
							<a class="sale-order-list-repeat-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><span><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></span></a>
						</div>
						<div class="sale-order-list-cancel-container">
							<a class="sale-order-list-cancel-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"])?>"><span><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></span></a>
						</div>
					</div>
				</div>
			</div>
			<?
		}
	}
	else
	{
		$orderHeaderStatus = null;

		if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS']))
		{
			?>
			<h1 class="sale-order-title">
				<?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?>
			</h1>
			<?
		}

		foreach ($arResult['ORDERS'] as $key => $order)
		{
			if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y')
			{
				$orderHeaderStatus = $order['ORDER']['STATUS_ID'];
				?>
				<h1 class="sale-order-title">
					<?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?=htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])?>&raquo;
				</h1>
				<?
			}
			?>
			<div class="sale-order-list-container">
				<div class="sale-order-list-title-container">
					<h2 class="sale-order-list-title">
						<?=Loc::getMessage('SPOL_TPL_ORDER')?>
						<?=Loc::getMessage('SPOL_TPL_NUMBER_SIGN').$order['ORDER']['ACCOUNT_NUMBER']?>
						<?=Loc::getMessage('SPOL_TPL_FROM_DATE')?>
						<?=$order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT'])/*?>,
								<?=count($order['BASKET_ITEMS']);?>
								<?
								$count = count($order['BASKET_ITEMS']) % 10;
								if ($count == '1')
								{
									echo Loc::getMessage('SPOL_TPL_GOOD');
								}
								elseif ($count >= '2' && $count <= '4')
								{
									echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
								}
								else
								{
									echo Loc::getMessage('SPOL_TPL_GOODS');
								}
								?>
								<?=Loc::getMessage('SPOL_TPL_SUMOF')?>
								<?=$order['ORDER']['FORMATED_PRICE']*/?>
					</h2>
				</div>
				<div class="sale-order-list-inner-container">
					<div class="sale-order-list-inner-title-line">
						<b><?echo GetMessage("SPOD_NAME")?></b>
						<b><?echo GetMessage("SPOD_PRICE")?></b>
						<b><?echo GetMessage("SPOD_QUANTITY")?></b>
						<b><?echo GetMessage("SPOD_ORDER_PRICE")?></b>
					</div>
					<div class="sale_personal_order_list">
						<?
							foreach ($order["BASKET_ITEMS"] as $item)
							{
								$measure = (isset($item["MEASURE_TEXT"])) ? $item["MEASURE_TEXT"] :GetMessage("STPOL_SHT");
								?>
								<div class="sale_personal_order_list_item">
									<div class="sale_personal_order_list_box">
										<span class="idn"><?echo GetMessage("SPOD_NAME")?>:</span>
										<div class="sale_personal_order_list_img">
											<img src="<?=($item['PICTURE']) ? $item['PICTURE'] : SITE_TEMPLATE_PATH . '/ilab/img/nophoto.png'?>" alt="<?=$item["NAME"]?>">
										</div>
										<div class="sale_personal_order_list_name">
											<?
												if (strlen($item["DETAIL_PAGE_URL"]) > 0)
													echo '<a href="'.$item["DETAIL_PAGE_URL"].'">';
												echo $item["NAME"];
												if (strlen($item["DETAIL_PAGE_URL"]) > 0)
													echo '</a>';
											?>
										</div>
									</div>
									<div class="sale_personal_order_list_price">
										<span class="idn"><?echo GetMessage("SPOD_PRICE")?>:</span>
										<b><?=round($item["PRICE"])?> тг.</b>
									</div>
									<div class="sale_personal_order_list_quantity">
										<span class="idn"><?echo GetMessage("SPOD_QUANTITY")?>:</span>
										<b><?=$item["QUANTITY"] ?> <?=$measure?></b>
									</div>
									<div class="sale_personal_order_list_total">
										<span class="idn"><?echo GetMessage("SPOD_ORDER_PRICE")?>:</span>
										<b><?=$item["PRICE"] * $item["QUANTITY"]?> тг.</b>
									</div>
								</div>
								<?
							}
						?>
					</div>
					<?/*<div class="sale-order-list-inner-title-line">
								<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></span>
							</div>*/?>
					<?
						$showDelimeter = false;
						foreach ($order['PAYMENT'] as $payment)
						{
							if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
							{
								$paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
									"order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
									"payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
									"allow_inner" => $arParams['ALLOW_INNER'],
									"only_inner_full" => $arParams['ONLY_INNER_FULL']
								);
							}
							?>
							<div class="sale-order-list-inner-row">
								<?
									if ($showDelimeter)
									{
										?>
										<div class="sale-order-list-top-border"></div>
										<?
									}
									else
									{
										$showDelimeter = true;
									}
								?>

								<div class="sale-order-list-inner-row-body">
									<div class="sale-order-list-payment">
										<?/*<div class="sale-order-list-payment-title">
												<?
												/*$paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL')." ".Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
												if(isset($payment['DATE_BILL']))
												{
													$paymentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
												}
												$paymentSubTitle .=",";*//*
												echo $paymentSubTitle;
												?>
												<span class="sale-order-list-payment-title-element"><?=$payment['PAY_SYSTEM_NAME']?>:</span>
											</div>*/?>
										<div class="sale-order-list-payment-price">
											<span class="sale-order-list-payment-element"><?=Loc::getMessage('SPOL_TPL_SUM_TO_PAID')?>:</span>
											<div class="sale-order-list-payment-status-box">
												<span class="sale-order-list-payment-number"><?=$payment['FORMATED_SUM']?></span>
												<?
													if ($payment['PAID'] === 'Y')
													{
														?>
														<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_PAID')?></span>
														<?
													}
													elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
													{
														?>
														<span class="sale-order-list-status-restricted"><?=Loc::getMessage('SPOL_TPL_RESTRICTED_PAID')?></span>
														<?
													}
													else
													{
														?>
														<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTPAID')?></span>
														<?
													}
												?>
											</div>
										</div>
										<div class="sale-order-list-payment-pay-check-box">
											<span class="sale-order-list-payment-pay-check-title"><?=Loc::getMessage('SPOL_PAYED')?>:</span>
											<?if($payment['PAID'] == 'Y'):?>
												<b class="sale-order-list-payment-pay-check"><?=Loc::getMessage('SPOL_YES')?></b>
											<?else:?>
												<b class="sale-order-list-payment-pay-check"><?=Loc::getMessage('SPOL_NO')?></b>
											<?endif;?>
										</div>
										<div class="sale-order-list-payment-name-box">
											<span class="sale-order-list-payment-name-title"><?=Loc::getMessage('SPOL_PAYSYSTEM')?>:</span>
											<b class="sale-order-list-payment-name"><?=$payment['PAY_SYSTEM_NAME']?></b>
										</div>
										<?
											if (!empty($payment['CHECK_DATA']))
											{
												$listCheckLinks = "";
												foreach ($payment['CHECK_DATA'] as $checkInfo)
												{
													$title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID']))." - ". htmlspecialcharsbx($checkInfo['TYPE_NAME']);
													if (strlen($checkInfo['LINK']))
													{
														$link = $checkInfo['LINK'];
														$listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
													}
												}
												if (strlen($listCheckLinks) > 0)
												{
													?>
													<div class="sale-order-list-payment-check">
														<div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE')?>:</div>
														<div class="sale-order-list-payment-check-left">
															<?=$listCheckLinks?>
														</div>
													</div>
													<?
												}
											}
											if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y')
											{
												?>
												<div class="sale-order-list-status-restricted-message-block">
													<span class="sale-order-list-status-restricted-message"><?=Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE')?></span>
												</div>
												<?
											}
										?>

									</div>
									<?/*if(
											$payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y'
											||
											$payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
										):?>
											<div class="sale-order-list-button-container">
												<?
												if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y')
												{
													if ($order['ORDER']['IS_ALLOW_PAY'] == 'N')
													{
														?>
														<a class="sale-order-list-button inactive-button">
															<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
														</a>
														<?
													}
													elseif ($payment['NEW_WINDOW'] === 'Y')
													{
														?>

														<a class="sale-order-list-button" target="_blank" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
															<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
														</a>
														<?
													}
													else
													{
														?>
														<a class="sale-order-list-button ajax_reload" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>">
															<span><?=Loc::getMessage('SPOL_TPL_PAY')?></span>
														</a>
														<?
													}
												}
												if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
												{
													?>
													<a href="#" class="sale-order-list-change-payment" id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>">
														<span id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>"><?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?></span>
													</a>
													<?
												}
												?>
											</div>
										<?endif*/?>
								</div>
								<div class="sale-order-list-inner-row-template">
									<a class="sale-order-list-cancel-payment">
										<i class=""></i> <?=Loc::getMessage('SPOL_CANCEL_PAYMENT')?>
									</a>
								</div>
							</div>
							<?
						}
						if (!empty($order['SHIPMENT']))
						{
							?>
							<?/*<div class="sale-order-list-inner-title-line">
									<span class="sale-order-list-inner-title-line-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></span>
								</div>*/?>
							<?
						}
						$showDelimeter = false;
						foreach ($order['SHIPMENT'] as $shipment)
						{
							if (empty($shipment))
							{
								continue;
							}
							?>
							<div class="sale-order-list-inner-row">
								<?
									if ($showDelimeter)
									{
										?>
										<div class="sale-order-list-top-border"></div>
										<?
									}
									else
									{
										$showDelimeter = true;
									}
								?>
								<div class="sale-order-list-shipment">
									<?/*<div class="sale-order-list-shipment-title">
											<span class="sale-order-list-shipment-element">
												<?/*=Loc::getMessage('SPOL_TPL_LOAD')?>
												<?
												$shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN').htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
												if ($shipment['DATE_DEDUCTED'])
												{
													$shipmentSubTitle .= " ".Loc::getMessage('SPOL_TPL_FROM_DATE')." ".$shipment['DATE_DEDUCTED']->format($arParams['ACTIVE_DATE_FORMAT']);
												}

												if ($shipment['FORMATED_DELIVERY_PRICE'])
												{
													$shipmentSubTitle .= ", ".Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];
												}*//*
												$shipmentSubTitle = Loc::getMessage('SPOL_TPL_DELIVERY_COST')." ".$shipment['FORMATED_DELIVERY_PRICE'];

												echo $shipmentSubTitle;
												?>:
											</span>
											<?
											if ($shipment['DEDUCTED'] == 'Y')
											{
												?>
												<span class="sale-order-list-status-success"><?=Loc::getMessage('SPOL_TPL_LOADED');?></span>
												<?
											}
											else
											{
												?>
												<span class="sale-order-list-status-alert"><?=Loc::getMessage('SPOL_TPL_NOTLOADED');?></span>
												<?
											}
											?>
										</div>

										<div class="sale-order-list-shipment-status">
											<span class="sale-order-list-shipment-status-item"><?=Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS');?>:</span>
											<span class="sale-order-list-shipment-status-block sale-order-list-<?=($shipment['STATUS_ID']=='DF') ? 'green' : 'orange'?>"><?=htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME'])?></span>
										</div>*/?>

									<?
										if (!empty($shipment['DELIVERY_ID']))
										{
											?>
											<div class="sale-order-list-shipment-item">
												<span class="sale-order-list-shipment-item-item"><?=Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE')?>:</span>
												<span class="sale-order-list-shipment-item-block"><?= htmlspecialcharsbx($shipment["DELIVERY_NAME"])?><?//=$arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]['NAME']?></span>
											</div>
											<?
										}

										if (!empty($shipment['TRACKING_NUMBER']))
										{
											?>
											<div class="sale-order-list-shipment-item">
												<span class="sale-order-list-shipment-id-name"><?=Loc::getMessage('SPOL_TPL_POSTID')?>:</span>
												<span class="sale-order-list-shipment-id"><?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?></span>
												<span class="sale-order-list-shipment-id-icon"></span>
											</div>
											<?
										}
									?>
								</div>
								<?
									if (strlen($shipment['TRACKING_URL']) > 0)
									{
										?>
										<div class="sale-order-list-shipment-button-container">
											<a class="sale-order-list-shipment-button" target="_blank" href="<?=$shipment['TRACKING_URL']?>">
												<?=Loc::getMessage('SPOL_TPL_CHECK_POSTID')?>
											</a>
										</div>
										<?
									}
								?>
							</div>
							<?
						}
					?>

					<div class="sale-order-list-inner-row sale-order-list-url-container">
						<div class="sale-order-list-about-container">
							<a class="sale-order-list-about-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"])?>"><span><?=Loc::getMessage('SPOL_TPL_MORE_ON_ORDER')?></span></a>
						</div>
						<div class="sale-order-list-repeat-container">
							<a class="sale-order-list-repeat-link" href="<?=htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"])?>"><span><?=Loc::getMessage('SPOL_TPL_REPEAT_ORDER')?></span></a>
						</div>
					</div>
				</div>
			</div>

<?
		}
	}
	?>
	<?
	echo $arResult["NAV_STRING"];

	if ($_REQUEST["filter_history"] !== 'Y')
	{
		$javascriptParams = array(
			"url" => CUtil::JSEscape($this->__component->GetPath().'/ajax.php'),
			"templateFolder" => CUtil::JSEscape($templateFolder),
			"paymentList" => $paymentChangeData
		);
		$javascriptParams = CUtil::PhpToJSObject($javascriptParams);
		?>
		<script>
			BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?=$javascriptParams?>);
		</script>
		<?
	}
}
?>
</div>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre">
		<?//print_r($arParams)?>
		<?print_r($arResult)?>
	</pre>
<?endif*/?>