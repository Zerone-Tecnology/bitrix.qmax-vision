<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
//$this->setFrameMode(true);

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\Application;

$docRoot = Application::getDocumentRoot();

Loc::loadMessages($docRoot.SITE_TEMPLATE_PATH.'/header.php');
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>

	<nav class="i_menu_overflow">
		<div class="i_mo_ad j_mo_ad">
			<span class="i_mo_x j_mo_x"><div class="i_mo_icon j_mo_icon"></div></span>
			<span class="i_mo_ad_but">Меню<?//=Loc::getMessage('MENU')?></span>
		</div>
		<ul class="i_mo j_mo">
			<?foreach($arResult as $k=>$e):?>
				<li<?if($e['ITEMS'])echo ' class="i_mo_sub j_mo_sub"'?>>
					<a href="<?=$e['LINK']?>"<?if($e['SELECTED'])echo ' class="i_mo_selected"'?>><?=$e['TEXT']?></a>

					<?if($e['ITEMS']):?>
						<ul class="i_mo_inside">
							<?foreach($e['ITEMS'] as $ik=>$ie):?>
								<li>
									<a href="<?=$ie['LINK']?>"<?if($ie['SELECTED'])echo ' class="i_mo_selected"'?>><?=$ie['TEXT']?></a>
								</li>
							<?endforeach?>
						</ul>
					<?endif?>

				</li>
			<?endforeach?>
			<li class="i_mo_more j_mo_more">
				<span><?=Loc::getMessage('MORE')?></span>
				<ul class="i_mo_inside j_mo_inside"></ul>
			</li>
		</ul>
	</nav>


<?/*<nav class="i_menu_overflow">
	<div class="i_mo_ad j_mo_ad">
		<a class="i_mo_x j_mo_x"><div class="i_mo_icon j_mo_icon"></div></a>
		<span class="i_mo_ad_txt">Меню<?//=Loc::getMessage('MENU')?></span>
	</div>
	<ul class="i_mo j_mo">
		<li>
			<a href="/">1 Home</a>
		</li>
		<li>
			<a href="/">2 Blog</a>
		</li>
		<li>
			<a href="/">3 Works</a>
		</li>
		<li>
			<a href="/">4 Contact</a>
		</li>
		<li class="i_mo_sub j_mo_sub">
			<a href="/">5 About</a>
			<ul class="i_mo_inside">
				<li>
					<a href="/">Sub menu 1</a>
				</li>
				<li>
					<a href="/">Sub menu 2</a>
				</li>
				<li>
					<a href="/">Sub menu 3</a>
				</li>
				<li>
					<a href="/">Sub menu 4</a>
				</li>
				<li>
					<a href="/">Sub menu 5</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="/" class="i_mo_selected">6 Menu</a>
		</li>
		<li>
			<a href="/">7 Menu</a>
		</li>
		<li class="i_mo_sub j_mo_sub">
			<a href="/" class="i_mo_selected">8 Menu</a>
			<ul class="i_mo_inside">
				<li>
					<a href="/">Sub menu 1</a>
				</li>
				<li>
					<a href="/" class="i_mo_selected">Sub menu 2</a>
				</li>
				<li>
					<a href="/">Sub menu 3</a>
				</li>
			</ul>
		</li>
		</li>
		<li>
			<a href="/">9 Menu</a>
		</li>
		<li>
			<a href="/">10 Menu</a>
		</li>
		<li class="i_mo_more j_mo_more">
			<span><?=GetMessage('MORE')?></span>
			<ul class="i_mo_inside j_mo_inside"></ul>
		</li>
	</ul>
</nav>*/?>

<?/*


	<ul class="i_tm jq_tm aclear">
	<?foreach($arResult as $k=>$e):?>
		<li class="i_tm_item jq_tm_item ifleft iprel" key="<?=$k?>">
			<a class="i_tm_a jq_tm_a iprel<?if($e['SELECTED'])echo ' i_tm_selected im_selected';if($e['ITEMS'])echo ' i_more'?>" href="<?=$e['LINK']?>"><?=$e['TEXT']?></a>

			<?if($e['ITEMS']):?>
				<ul class="i_sub jq_sub ipabs idnone">
				<?foreach($e['ITEMS'] as $ik=>$ie):?>
					<li class="i_sub_item">
						<a class="i_sub_a jq_sub_a<?if($ie['SELECTED'])echo ' i_sub_selected'?>" href="<?=$ie['LINK']?>"><?=$ie['TEXT']?></a>
					</li>
				<?endforeach?>
				</ul>
			<?endif?>

		</li>
	<?endforeach?>
		<li class="i_tm_item ifleft jq_tm_imore iprel">
			<a class="i_tm_a i_more jq_tm_a iprel" href="javascript:void(0)"><?=GetMessage('MORE')?></a>

			<ul class="i_sub jq_more jq_sub ipabs idnone i_tm_left">
			<?foreach($arResult as $k=>$e):?>
				<li class="i_sub_item jq_sub_item iprel" key="<?=$k?>">
					<a class="i_sub_a jq_sub_a<?if($e['ITEMS'])echo ' ijq_hsub';if($e['SELECTED'] && $e['ITEMS'])echo ' i_mo_selected im_selected';elseif($e['SELECTED'])echo ' i_sub_selected'?>" href="<?=$e['LINK']?>"><?=$e['TEXT']?></a>

					<?if($e['ITEMS']):?>
						<ul class="i_mo jq_mo ipabs idnone">
							<?foreach ($e['ITEMS'] as $ik=>$ie):?>
								<li class="i_mo_item" key="<?=$ik?>">
									<a class="i_mo_a jq_mo_a<?if($ie['SELECTED'])echo ' i_sub_selected'?>" href="<?=$ie['LINK']?>"><?=$ie['TEXT']?></a>
								</li>
							<?endforeach?>
						</ul>
					<?endif?>
				</li>
			<?endforeach?>
			</ul>

		</li>
	</ul>
*/?>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>