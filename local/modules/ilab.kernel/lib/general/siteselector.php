<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

use Bitrix\Main\{Application, Web\Cookie, Context};

class siteSelector
{

	protected static $name = 'setcity';

	function __construct()
	{

		$request = Context::getCurrent()->getRequest();

		if( $request[self::$name] )
			self::requestSite();
		else
			self::setSite( $request->getCookie('I_CITY_ID') ?? main::GetDefaultSiteID() );

	}

	public function requestSite()
	{

		$request = Context::getCurrent()->getRequest();
		$context = Application::getInstance()->getContext();

		$cookie = new Cookie('I_CITY_ID', htmlspecialchars($request[self::$name]));
		$cookie->setDomain($context->getServer()->getServerName());

		$context->getResponse()->addCookie($cookie);

		self::setSite($cookie->getValue());// Bitrix\Main\Context::getCurrent()->getSite(); || ilab\kernel\general\siteSelector::getSite();

	}

	public function getSite()
	{

		return Context::getCurrent()->getSite();

	}

	public function setSite($s)
	{

		Context::getCurrent()->setSite($s);

	}

}