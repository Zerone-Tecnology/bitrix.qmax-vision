<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["ORDER"]))
{
	?>
    <h3><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h3>
    <br>
    <table class="sale_order_full_table">
        <tr>
            <td>
				<?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => mb_substr($arResult["ORDER"]["DATE_INSERT"],0,-3), "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?>
                <br /><br />
				<?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
            </td>
        </tr>
    </table>
	<?
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
        <br /><br />

        <table class="sale_order_full_table">
            <tr>
                <td colspan="2">
                    <h4 class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></h4>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="ps_logo" width="100px"><div class="pay_logo"><span class="payment<?=$arResult['PAY_SYSTEM']['ID']?>" style="background-image: url(<?=$arResult['PAY_SYSTEM']['LOGOTIP']['SRC']?>)"></span></div></td>
                <td valign="top"><div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div>
					<?if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0):?>
						<?if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y"):?>
                            <script language="JavaScript">
                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                            </script>
						<?if($arResult['PAY_SYSTEM']['ID'] == 3)
						{
							echo GetMessage("SOA_TEMPL_PAY_LINK_BILL", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))));
						}
						else
							echo GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))));?>
						<?if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE'])):?>
                        <br />
							<?=GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y"))?>
						<?endif;
						else:
							if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
								include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
						endif;
					endif?>
                </td>
        </table>
		<?
	}
}
else
{
	?>
    <b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />

    <table class="sale_order_full_table">
        <tr>
            <td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>
	<?
}
?>
<?if(!$_COOKIE['ENHANCED_ECOMMERCE_'.$arResult['ORDER_ID']]):
	SetCookie('ENHANCED_ECOMMERCE_'.$arResult['ORDER_ID'], 'Y');?>
    <script type="text/javascript">
        dataLayer.push({
            'ecommerce':
                {
                    'purchase':
                        {
                            'actionField':
                                {
                                    'id':		'<?=$arResult['ORDER_ID']?>',// ID заказ
                                    'revenue':	'<?=$arResult['ORDER']['PRICE']?>',// Сумма заказа
                                    'tax':		'<?=$arResult['ORDER']['TAX_VALUE']?>',// НДС
									<?if($arResult['I_DELIVERY']['NAME']):?>
                                    'shipping':	'<?=$arResult['I_DELIVERY']['NAME']?>'// Название доставки
									<?endif?>
                                },
                            'products':
                                [
									<?foreach($arResult['I_BASK'] as $e):?>
                                    {
                                        'name':		'<?=$e['NAME']?>',
                                        'id':		'<?=$e['PRODUCT_ID']?>',
                                        'price':	'<?=$e['PRICE']?>',
                                        //							'brand':	'Google',// Бренд под вопросом
                                        'category':	'<?=$arResult['I_PRODUCT_SECTION'][$e['PRODUCT_ID']]['NAME']?>',
                                        'quantity':	'<?=$e['QUANTITY']?>'
                                    },
									<?endforeach?>
                                ]
                        }
                },
            'event':'gtm-enhanced-ecommerce'
        });
    </script>
<?endif?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>