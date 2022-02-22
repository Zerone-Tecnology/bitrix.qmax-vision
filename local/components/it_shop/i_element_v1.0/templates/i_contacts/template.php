<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// Нельзя просто так взять и подключить карты :)
// Не включать КЭШ компоненты!
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);?>
    <div class="i_contacts">
		<?foreach($arResult['ITEMS'] as $k=>$e):
			$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
            <div id="<?=$this->GetEditAreaId($e['ID']);?>">

				<?if( $e['PRO']['I_PANORAMA']['VALUE']['TEXT'] ):?>
                    <div class="i_panorama"><?=$e['PRO']['I_PANORAMA']['~VALUE']['TEXT']?></div>
				<?endif?>

				<?if(count($arResult['ITEMS'])>2):?>
                    <div class="i_cont_title<?if($k>0)echo ' i_cont_title_bord'?>"><?=$e['NAME']?></div>
				<?endif?>
				<?if( $e['PRO']['I_ADDRESS_'.$l]['~VALUE']['TEXT'] ):?>
                    <div class="i_cont_address">
                        <b><?=GetMessage('I_ADDRESS_NAME');?>:</b>
                        <br>
						<?=$e['PRO']['I_ADDRESS_'.$l]['~VALUE']['TEXT']?>
                    </div>
				<?endif?>
				<?if( $e['PRO']['I_TELEPHONE_'.$l]['~VALUE']['TEXT'] ):?>
                    <div class="i_cont_telephone">
                        <b><?=GetMessage('I_TELEPHONE_NAME');?>:</b>
                        <br>
						<?=$e['PRO']['I_TELEPHONE_'.$l]['~VALUE']['TEXT']?>
                    </div>
				<?endif?>
				<?if( $e['PRO']['I_EMAIL_'.$l]['~VALUE']['TEXT'] ):?>
                    <div class="i_cont_email">
                        <b><?=GetMessage('I_EMAIL_NAME');?>:</b>
                        <br>
						<?=$e['PRO']['I_EMAIL_'.$l]['~VALUE']['TEXT']?>
                    </div>
				<?endif?>
				<?if( $e['PRO']['I_REQUISITES_'.$l]['~VALUE']['TEXT'] ):?>
                    <div class="i_cont_requisites">
                        <b><?=GetMessage('I_REQUISITES_NAME');?>:</b>
                        <br><br>
						<?=$e['PRO']['I_REQUISITES_'.$l]['~VALUE']['TEXT']?>
                    </div>
				<?endif?>
				<?if($e['I_MAP']):?>
                    <div class="i_cont_map_block">
                        <div class="i_cont_map_nblock aclear">
                            <div class="i_cont_map_po i_cont_act jq_cont_point ifleft" jqid="1"><span><?=GetMessage('CONT_MAP')?></span></div>
							<?if( $e['D_PRO']['DRIVING_DIRECTIONS']['FILE_VALUE']['SRC'] ):?>
                                <div class="i_cont_drdi_po jq_cont_point ifleft" jqid="2"><span><?=GetMessage('DRIVING_DIRECTIONS')?></span></div>
							<?endif?>
                        </div>
                        <div class="i_cont_map jq_cont_dpoint" jqid="1">
							<?=$e['I_MAP']//=$e['D_PRO']['GOOGLE_MAP']['DISPLAY_VALUE']?>
                        </div>
						<?if( $e['D_PRO']['DRIVING_DIRECTIONS']['FILE_VALUE']['SRC'] ):?>
                            <div class="i_cont_drdi jq_cont_dpoint idnone" jqid="2">
                                <img src="<?=$e['D_PRO']['DRIVING_DIRECTIONS']['FILE_VALUE']['SRC']?>">
                            </div>
						<?endif?>
                    </div>
				<?endif?>

            </div>
		<?endforeach?>
    </div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>