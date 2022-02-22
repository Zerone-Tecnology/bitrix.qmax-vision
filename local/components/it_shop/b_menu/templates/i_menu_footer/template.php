<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>

	<nav class="i_f_menu">
		<div class="i_fm_ad j_fm_ad">
			<a class="i_fm_x j_fm_x"><div class="i_fm_icon j_fm_icon"></div></a>
			<span class="i_fm_ad_but">Меню<?//=Loc::getMessage('MENU')?></span>
		</div>
		<ul class="i_fm j_fm">
			<?foreach($arResult as $e):
				/*if( is_int($i/$arParams['I_POINT']) && $i>0 && $p<3 ){ $p++;echo '</div><div class="i_ml20 ifleft">'; }
				if( ($arParams['MAX_LEVEL'] == 1 && $e['DEPTH_LEVEL'] > 1) || $e['IS_PARENT'])
					continue;*/?>
				<li>
					<a href="<?=$e['LINK']?>"<?if($e['SELECTED'])echo ' class="selected"'?>><?=$e['TEXT']?></a>
				</li>
			<?endforeach?>
		</ul>
	</nav>

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
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>