<?
// ---------------------------------------------------------------------------------------------------- iLaB kernel

namespace ilab\kernel\general;

class sort
{

	public function Map(array $arFile, array $arOrder)
	{

		if( $arFile )
		{

			main::ma($arOrder);

			if( $arOrder[0] )
				self::_SortStart($arFile, $arOrder[0]);

			if( $arOrder[1] )
				self::_SortEnd($arFile, $arOrder[1]);

			return $arFile;

		} else
			return false;

	}

	protected function _SortStart(array &$arFile, array $arOrder)
	{

		$arSort = self::_Sort($arFile, $arOrder);

		$arFile = array_values( $arSort+array_diff($arFile, $arSort) );

//		return $arFile;

	}

	protected function _SortEnd(array &$arFile, array $arOrder)
	{

		$arSort = self::_Sort($arFile, $arOrder);

		$arFile = array_values( array_diff($arFile, $arSort)+$arSort );

//		return $arFile;

	}

	protected function _Sort(array $arFile, array $arOrder)
	{

		$arSort = [];

		// sort
		foreach($arOrder as $e)
		{

			$f = array_filter($arFile, function($f) use($e) {

				$p = pathinfo($f);

				// .min.[extension]
				if( preg_match('/(.+)\\.min$/i', $p['filename'], $m) )
					$p['filename'] = $m[1];

				return $p['filename']==$e;

			});

			if( $f )
				$arSort = $arSort+$f;

		}unset($e,$f,$p);

		return $arSort;

	}

}