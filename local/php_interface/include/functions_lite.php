<?
// Dump an array
function dd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// Returns array as string value
function array_to_string($var)
{
    ob_start();
    print_r($var);
    $result = ob_get_clean();
    return $result;
    return '';
}

// Writes array, object, string or number to [ file ]
function wr_file($var, $filename = "log_zerone")
{
    $date = new DateTime("now", new DateTimeZone('Asia/Almaty'));
    $date = $date->format('Y-m-d H:i:s');

    $sFile = $_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/" . $filename . ".txt";
    $rsHandler = fopen($sFile, "a+");
    fwrite($rsHandler, "--------------------" . $date . "--------------------" . PHP_EOL);
    fwrite($rsHandler, array_to_string($var) . PHP_EOL);
    fwrite($rsHandler, "-----------------------------------------------------------" . PHP_EOL);
    fclose($rsHandler);
}
?>