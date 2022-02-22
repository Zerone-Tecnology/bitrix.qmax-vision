<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel [PHP - Class module]

namespace ilab\kernel\general;

use	Bitrix\Main\Application;

class file
{

	public function GetList(array $p)
	{

		if( $p )
		{

			main::ma($p);

			$arResult = [];

			foreach($p as $e)
			{

				$cache[$e['PATH']] = self::GetPath($e['PATH'], $e['EXT'], $e['SUB'], $e['EXC'], $e['MIN'], $e['TAKE']);

				$arResult = array_merge($arResult, $cache);

			}unset($e,$cache);

			return $arResult;

		} else
			return false;

	}

	public function GetPath(string $path, string $ext, $exc = false, $sub = false, $min = false, $take = false)
	{

		// $_SERVER['DOCUMENT_ROOT']
		$docRoot = Application::getDocumentRoot();

		if( $path && file_exists($docRoot.$path) )
		{

			// scan directory
			$root = array_diff(scandir($docRoot.$path), ['..', '.']);

			foreach($root as $k=>$f)
			{

				// directory ?
				if( is_dir($docRoot.$path.$f) )
				{

					// subfolders
					if( !$sub )
						continue;

// -------------------------------------------------- Refactoring method ?
					// exclude folder
					if( $exc && array_key_exists($f, $exc) )
					{

						$s = true;

						if( $in = is_array($exc[$f]) && $exc[$f]['IN'] ? (array) $exc[$f]['IN'] : (is_array($exc[$f]) && $exc[$f]['EX'] ? false : $exc[$f] ) )
						{
							foreach($in as $i)
								if( main::InDir($i) )
									$s = false;
						} else
							$s = null;

						if( $ex = is_array($exc[$f]) && $exc[$f]['EX'] ? (array) $exc[$f]['EX'] : false )
							foreach($ex as $e)
								if( main::InDir($e) )
									$s = true;
/*
// remove after testing
echo '<pre>';
if( $s )
	echo 'work -----'.'<br>';
echo $l.'ilab\kernel\general\file work result pre |'.$f.'|'.$br;
echo '<br>'.'IN:'.'<br>';
print_r($in);
echo '<br>'.'EX:'.'<br>';
print_r($ex);
echo '</pre>';
*/
						if( $s )
							continue;

					}unset($s,$in,$i,$ex,$e);

				}

				// file ?
				if( is_file($docRoot.$path.$f) )
				{

					$e = pathinfo($docRoot.$path.$f);

					// extension
					if( $ext && $ext != $e['extension'] )
						continue;

					// .min.[ext]
					if( !$min && preg_match('/(.+)\.(min.'.$ext.')$/i', $f) )
						continue;

					// take and min == true
					if( $take && $min && !preg_match('/(.+)\\.min$/i', $e['filename'], $m) && in_array($e['filename'].'.min.'.$e['extension'], $root) )
						continue;

					$arFile[$e['extension']][] = $path.$f;

					continue;

				}

				// recursive
				$arFile = array_merge_recursive( (array) $arFile, (array) self::GetPath($path.$f.'/', $ext, false, $sub, $min, $take) );

			}unset($k,$f,$e,$m);

			return $arFile;

		} else
			return false;

	}

}