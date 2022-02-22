<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="i_sale-personal-account-wallet-container">
	<div class="i_sale-personal-account-wallet-title">
		<?=Bitrix\Main\Localization\Loc::getMessage('SPA_BILL_AT')?>
		<?=$arResult["DATE"];?>
	</div>
	<div class="i_sale-personal-account-wallet-list-container">
		<div class="i_sale-personal-account-wallet-list">
			<?
			foreach($arResult["ACCOUNT_LIST"] as $accountValue)
			{
				?>
				<div class="i_sale-personal-account-wallet-list-item">
					<div class="i_sale-personal-account-wallet-currency">
						<div class="i_sale-personal-account-wallet-currency-item"><?=$accountValue['CURRENCY']?></div>
						<div class="i_sale-personal-account-wallet-currency-item"><?=$accountValue["CURRENCY_FULL_NAME"]?></div>
					</div>
					<div class="i_sale-personal-account-wallet-sum"><?=$accountValue['SUM']?></div>
				</div>
				<?
			}
			?>
		</div>
	</div>
</div>