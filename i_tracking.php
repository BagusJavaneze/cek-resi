<?php


$resi = $_POST['resi'];
$jasa = $_POST['jasa'];


//jika jne
if ($jasa == "jne")
	{
	$base = "https://track.aftership.com/jne/$resi?";
	}
	
	
//jika pos
if ($jasa == "pos")
	{
	$base = "https://track.aftership.com/pos-indonesia/$resi?";
	}
	
	
//jika tiki
if ($jasa == "tiki")
	{
	$base = "https://track.aftership.com/tiki/$resi?";
	}
	

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$str = curl_exec($curl);
curl_close($curl);

//sempurnakan
$start = "<div class=\"checkpoints\">";
$end   = "Date & time are usually";
$startPosisition = strpos($str, $start);
$endPosisition   = strpos($str, $end); 

$longText = $endPosisition - $startPosisition;

$result = substr($str, $startPosisition, $longText);	

//hilangkan
function hilangkan($str)
{
    $str = trim($str);
	$search = array ("'Indonesia'");
	$replace = array ("");

	$str = preg_replace($search, $replace, $str);
	return $str;
}

//bikin file html
function bikinfile($text, $filename='hasil_resi.html')
{
	if (!file_exists(realpath('./cache'))) {
	   mkdir(dirname(__FILE__).'/cache', 0775, true);
	}
	
	//tulis text ke file
	$myfile = fopen(realpath('./cache').'/'.$filename, "w") or die("Unable to open file!");
	fwrite($myfile, $text);
	return fclose($myfile);
}


$finalResult = hilangkan($result);
$finalString = preg_replace("/\r|\n/", "", $finalResult);
$data = bikinfile($finalString);


//jika salah
if ($data && !empty($finalString))
{
	echo json_encode([
		'write_status' => $data
	]);
}
else
{
	echo json_encode(["EMPTY"]);
}


?>
