<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame('jq_hbasket', false)->begin();
$frame->setAnimation(true);
// ---------------------------------------------------------------------------------------------------- iLaB?>
<?
$price	= 0;
$count	= 0;
$id		= '↕';
$lid	= SITE_ID;
if( $arParams['CURRENCY_ID'] )
	$cur	= $arParams['CURRENCY_ID'];
else
	$cur	= 'KZT';

if($arResult['ITEMS'])
foreach ($arResult['ITEMS'] as $v)
{
	if ($v['DELAY']=='N' && $v['CAN_BUY']=='Y')
	{
		$price	+= $v['QUANTITY']*$v['PRICE'];
		$count	+= $v['QUANTITY'];
		$id		.= $v['PRODUCT_ID'].'↕';
		$cur	 = $v['CURRENCY'];
	}
}?>
	<a href="<?=$arParams['PATH_TO_BASKET']?>" class="i_hbask jq_hbask" jq_lid="<?=$lid?>">
		<b class="i_hbask_name ifont185"><?=GetMessage('BASKET')?></b>
		<div class="i_hbask_cont">
			<div class="i_hbask_cont_row">
				<b><?=GetMessage('GOODS')?>:</b><span class="jq_basket_co"><?=$count//=number_format($count,2,'.','')?></span><span class="i_hbask_pieces"><?=GetMessage('PIECES')?></span>
			</div>
			<div class="i_hbask_cont_row">
				<b><?=GetMessage('AMOUNT')?>:</b><span class="jq_basket_pr"><?=mb_substr(CurrencyFormat($price, $cur), 0, -4)?></span><span class="i_cur i_hbask_pieces">тг.</span>
			</div>
		</div>
	</a>
<input type="hidden" value="<?=$id?>" class="jq_basket_id" data-ids='<?=json_encode($arResult['ILAB']['JSON']['IDS'] ?? (array) null)?>' data-d='<?=json_encode($arResult['ILAB']['JSON']['BASKET'] ?? (object) null)?>' data-l='<?=json_encode($arResult['ILAB']['JSON']['LINK_ID'] ?? (object) null)?>'>
<input type="hidden" value="" class="jq_favorite_id" data-id='<?=json_encode($arResult['ILAB']['JSON']['FAVORITE']['IDS'] ?? (array) null)?>' data-bids='<?=json_encode($arResult['ILAB']['JSON']['FAVORITE']['B_IDS'] ?? (array) null)?>'>

<?if($arResult['ITEMS']):?>
<script>
	function i_buy_buttom()
	{
		<?foreach($arResult['ITEMS'] as $e):
			if($e['DELAY']=='N'):?>
				if( $('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').length )
				{
					$('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').hide(0)
//						.siblings('.jq_count').hide(0)
						.siblings('.jq_delete_item').fadeIn(500).data('id', <?=$e['ID']?>).attr('jqid', <?=$e['ID']?>)
						.siblings('.jq_bought').fadeIn(500).css({opacity: 0, display: 'flex'}).animate({opacity:1},600).attr('jqbacount', '<?echo +($e['QUANTITY'])?>')
						.find('.j_m_ratio').text(<?echo +($e['QUANTITY'])?>);

//					$('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').hide(0).siblings('.jq_bought').attr('jqbacount', '<?echo +($e['QUANTITY'])?>').css({opacity: 0, display: 'inline-block'}).animate({opacity:1},600).siblings('.jq_delete_item').attr('jqid', <?=$e['ID']?>).show();
//					$('.jq_delete_item[jqid="<?=$e["PRODUCT_ID"]?>"]').fadeIn();
//					$('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').siblings('.jq_count').hide();
				}
			<?else:?>
				if( $('a.j_item_favorite[data-id="<?=$e["PRODUCT_ID"]?>"]').length )
				{
					$('a.j_item_favorite[data-id="<?=$e["PRODUCT_ID"]?>"]').attr('jq_bid', <?=$e['ID']?>).addClass('i_item_favorite_act').find('span').text($('a.j_item_favorite[data-id="<?=$e["PRODUCT_ID"]?>"]').data('change_text').txt_change);
				}
			<?endif;
		endforeach?>
		<?/*foreach($arResult['ITEMS'] as $e):
			if($e['DELAY']=='N'):?>
				if( $('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').length )
				{
					$('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').hide(0).siblings('.jq_bought').attr('jqbacount', '<?echo +($e['QUANTITY'])?>').css({opacity: 0, display: 'inline-block'}).animate({opacity:1},600).siblings('.jq_delete_item').attr('jqid', <?=$e['ID']?>).show();
					$('.jq_delete_item[jqid="<?=$e["PRODUCT_ID"]?>"]').fadeIn();
//					$('a.jq_buy[jq_id="<?=$e["PRODUCT_ID"]?>"]').siblings('.jq_count').hide();
				}
			<?else:?>
				if( $('a.jq_favorite[jq_id="<?=$e["PRODUCT_ID"]?>"]').length )
				{
					$('a.jq_favorite[jq_id="<?=$e["PRODUCT_ID"]?>"]').attr('jq_bid', <?=$e['ID']?>).addClass('i_item_favorite_act').find('span').text($('a.jq_favorite[jq_id="<?=$e["PRODUCT_ID"]?>"]').data('change_text').txt_change);
				}
			<?endif;
		endforeach*/?>
	}

	$(document).ready(function(){
			i_buy_buttom()
	});
</script>
<?endif;
// ---------------------------------------------------------------------------------------------------- iLaB?>
<?$frame->beginStub()?>
	<div class="i_hbask_loader"></div>
<?$frame->end()?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>