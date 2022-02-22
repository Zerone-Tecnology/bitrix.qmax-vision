<?/*
<div class="i_delivery_conditions">
	<div class="i_delivery_conditions_title">
		Условия поставки
	</div>
	<div class="i_delivery_conditions_item">
		<div class="i_delivery_conditions_item_title jq_m_stock">
			В наличии
		</div>
		<div class="i_delivery_conditions_item_content">
			В наличии - заказ будет доставлен по Алматы или отправлен по РК в тот же день или на следующий
			рабочий день. Доступен к самовывозу в тот же день.
		</div>
		<div class="i_delivery_conditions_item_link jq_m_stock">
			<span>подробнее</span>
		</div>
	</div>
	<div class="i_delivery_conditions_item">
		<div class="i_delivery_conditions_item_title jq_m_expected">
			Ожидается
		</div>
		<div class="i_delivery_conditions_item_content">
			Ожидается - заказ будет доставлен по Алматы или отправлен по РК в течение 5 рабочих дней. Товар
			резервируется для вас после предоплаты 10% стоимости товара.
		</div>
		<div class="i_delivery_conditions_item_link jq_m_expected">
			<span>подробнее</span>
		</div>
	</div>
	<div class="i_delivery_conditions_item">
		<div class="i_delivery_conditions_item_title jq_m_to_order">
			На заказ
		</div>
		<div class="i_delivery_conditions_item_content">
			На заказ - заказ будет доставлен по Алматы или отправлен по РК в течение 10-12 рабочих дней. Заказ
			размещается по предоплате 10% стоимости товара.
		</div>
		<div class="i_delivery_conditions_item_link jq_m_to_order">
			<span>подробнее</span>
		</div>
	</div>
</div>
*/?>
<?$APPLICATION->IncludeComponent(
	"it_shop:i_element_v1.0", 
	"i_lbanner_adaptive", 
	array(
		"IBLOCK_TYPE" => "imarket",
		"IBLOCK_ID" => "42",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"SECTION_ID" => "",
		"PROPERTY_CODE" => array(
			0 => "I_NAME_RU",
			1 => "I_LG_BANNER_RU",
			2 => "I_MD_BANNER_RU",
			3 => "I_SM_BANNER_RU",
			4 => "",
		),
		"I_LIMIT_TEASER" => "",
		"I_POINT" => "",
		"I_SECTION_ID" => $arParams["SECTION_ID"],
		"COMPONENT_TEMPLATE" => "i_lbanner_adaptive",
		"I_HEIGHT" => "",
		"I_RAND_ONE" => "N",
		"I_TITLE" => "Специальные предложения",
		"I_TITLE_LINK" => "/"
	),
	false
);?>