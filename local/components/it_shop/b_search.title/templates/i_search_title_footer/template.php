<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
    <div class="i_search_footer">
        <div id="<?=$CONTAINER_ID?>" class="i_search_flat  jq_search ipabs">
            <form action="<?=$arResult["FORM_ACTION"]?>">
                <input id="<?=$INPUT_ID?>" type="text" name="q" value="" placeholder="<?=GetMessage('SITE_SEARCH')?>" size="3" maxlength="300" autocomplete="off" />
                <input class="search-button" name="s" type="submit" value="<?=GetMessage("CT_BST_SEARCH_BUTTON");?>" />
            </form>
        </div>
    </div>
    <div class="i_search_mobile iprel">
        <span class="i_search_footer_mobile j_search_footer_mobile"></span>
        <div class="i_search_footer_mobile_cont idnone">
            <div id="<?=$CONTAINER_ID?>" class="i_search_flat  jq_search ipabs">
                <span class="i_s_close j_s_close"></span>
                <form action="<?=$arResult["FORM_ACTION"]?>">
                    <input id="<?=$INPUT_ID?>" type="text" name="q" value="" placeholder="<?=GetMessage('SITE_SEARCH')?>" size="3" maxlength="300" autocomplete="off" />
                    <input class="search-button" name="s" type="submit" value="<?=GetMessage("CT_BST_SEARCH_BUTTON");?>" />
                </form>
            </div>
        </div>
    </div>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>
