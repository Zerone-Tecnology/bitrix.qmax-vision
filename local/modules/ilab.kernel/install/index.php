<?defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
// ---------------------------------------------------------------------------------------------------- iLaB kernel

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

Class ilab_kernel extends CModule
{

	function __construct()
	{

		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		$this->MODULE_ID = 'ilab.kernel';
		$this->MODULE_VERSION = $arModuleVersion['VERSION'];
		$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		$this->MODULE_NAME = Loc::getMessage('ILAB_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('ILAB_MODULE_DESCRIPTION');

		$this->PARTNER_NAME = Loc::getMessage('ILAB_PARTNER_NAME');
		$this->PARTNER_URI = Loc::getMessage('ILAB_PARTNER_URI');

		$this->MODULE_SORT = 1;
//		$this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
//		$this->MODULE_GROUP_RIGHT = 'Y';

	}

	public function DoInstall()
	{

		$this->installDB();

		RegisterModuleDependences('main', 'OnBeforeProlog', 'ilab.kernel');		

		ModuleManager::registerModule($this->MODULE_ID);

		$this->InstallEvents();

	}

	public function DoUninstall()
	{

		$this->uninstallDB();

		UnRegisterModuleDependences('main', 'OnBeforeProlog', 'ilab.kernel');

		ModuleManager::unRegisterModule($this->MODULE_ID);

		$this->UnInstallEvents();

	}

	public function InstallEvents()
	{

		EventManager::getInstance()->registerEventHandler(
			'main',
			'OnBeforeProlog',
			$this->MODULE_ID,
			'ilab\kernel\init',
			'AutoLoad'
		);

		return true;

	}

	public function UnInstallEvents()
	{

		EventManager::getInstance()->unRegisterEventHandler(
			'main',
			'OnBeforeProlog',
			$this->MODULE_ID,
			'ilab\kernel\init',
			'AutoLoad'
		);

		return true;

	}

}