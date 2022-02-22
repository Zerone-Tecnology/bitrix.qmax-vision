<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>

	<div class="i_footmenu">
		<div class="i_footmenu_col">
			<?$i=0;foreach($arResult as $e):
				if( is_int($i/$arParams['I_POINT']) && $i>0 && $p<3 ){ $p++;echo '</div><div class="i_footmenu_col jq_footmenu_col">'; }
				if( ($arParams['MAX_LEVEL'] == 1 && $e['DEPTH_LEVEL'] > 1) || $e['IS_PARENT'])
					continue;?>

				<span>
					<a href="<?=$e['LINK']?>"<?if($e['SELECTED'])echo ' class="selected"'?>><?=$e['TEXT']?></a>
				</span>

			<?$i++;endforeach?>
		</div>
	</div>
	<div class="i_show_footmenu jq_show_footmenu idnone" data-mess='{
		"show":"<?=GetMessage('I_SHOW_FOOTMENU');?>",
		"hide":"<?=GetMessage('I_HIDE_FOOTMENU');?>"
	}'><span class="i_show"><?=GetMessage('I_SHOW_FOOTMENU');?></span></div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?/*

<div class="i_footmenu">
		<div class="ifleft">
			<?$i=0;foreach($arResult as $e):
				if( is_int($i/$arParams['I_POINT']) && $i>0 && $p<3 ){ $p++;echo '</div><div class="i_ml20 ifleft">'; }
				if( ($arParams['MAX_LEVEL'] == 1 && $e['DEPTH_LEVEL'] > 1) || $e['IS_PARENT'])
					continue;?>

				<span>
					<a href="<?=$e['LINK']?>"<?if($e['SELECTED'])echo ' class="selected"'?>><?=$e['TEXT']?></a>
				</span>

			<?$i++;endforeach?>
		</div>
		<div class="iclear"></div>
	</div>


*/?>


<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>