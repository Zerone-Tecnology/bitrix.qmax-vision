# ilab.kernel

Модуль ядра структуры ilab. В основном модуль ориентирован на собственные методы и решения.

## init.php

### Инициализации модуля ilab

Модуль подключается автоматически, после установки, до файла **/local/php_interface/init.php**

### Ручной метод инициализации модуля ilab

```php
use ilab\kernel\main;

/* ---------------------------------------------------------------------------------------------------- ilab.kernel */
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandlerCompatible('main', 'OnBeforeProlog', 'MyOnBeforePrologHandler');
function MyOnBeforePrologHandler()
{
	
	if( Bitrix\Main\Loader::includeModule('ilab.kernel') && PHP_SAPI != 'cli' )
	{
		//$start = microtime(true);

		new ilab\kernel\init(string $path = '/local/ilab/');

		//$time = microtime(true) - $start;
		//printf('Скрипт выполнялся %.4F сек.', $time);
	}
}
/* ---------------------------------------------------------------------------------------------------- ilab.kernel */
```

Инициализирует модуль структуры ilab.kernel

  * **$path** - путь до папки ilab, к примеру если папка размещена в шаблоне сайта (SITE_TEMPLATE_PATH.'/ilab/')
  * **PHP_SAPI != 'cli'** - не инициализировать через крон

В примере подключение модуля осуществляется в **/local/php_interface/init.php**

----

### Подключение стилей для разных каталогов сайта

К примеру подключение стилей **/ilab/css/basket/** исключительно для корзины и оформление заказа. Подробнее смотрите параметр **$exc** в примерах исключение в методе Класса File.

```php
$basket = [
	SITE_DIR.'personal/basket.php',
	SITE_DIR.'personal/order.php'
];
ilab\kernel\ilab\css::$exclude = [
	'main' => [
		'EX' => $basket
	],
	'basket' => $basket
];
```

Изменить статическую переменную **$exclude** нужно до инициализации нового экземпляра класса **ilab\kernel\init**.