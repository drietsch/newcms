<?
//ARRAY muss ersetzt werden!!!
$_data = unserialize($_REQUEST["dta"]);
foreach ($_data as $key => $value)
{
$out .= "data".($key+1)."series1:".$value."\n";
}
echo trim($out);

//echo "data1series1:3\n";
//echo "data2series1:7\n";

?>