<?php
ini_set("memory_limit", "2028M");
ini_set("post_max_size", "512M");
ini_set("upload_max_filesize", "512M");
ini_set("max_execution_time", "900000");
ini_set("max_input_time", "6000");
ini_set('auto_detect_line_endings', '1');

ini_set('display_errors', 'on');
error_reporting(E_ALL);
libxml_use_internal_errors(TRUE);


echo $_SERVER['SERVER_NAME'];
exit;
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php'); 

use \Bitrix\Main,   
    \Bitrix\Main\Localization\Loc as Loc,    
    Bitrix\Main\Loader,
    Bitrix\Main\Application,
   Bitrix\Currency,    
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Sale\Affiliate,
    Bitrix\Sale\DiscountCouponsManager,
    Bitrix\Main\Context; 

Bitrix\Main\Loader::includeModule("sale");

class Suggestions 
{
    private $url,
            $token;
    
    public function __construct($token, $url = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/') 
	{
        $this->token = $token;
        $this->url = $url;
    }
    
    public function suggest($resource, $data) 
	{
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => array(
                    'Content-type: application/json',
                    'Accept: application/json',
                    'Authorization: Token ' . $this->token,
                ),
                'content' => json_encode($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($this->url . $resource, false, $context);
        return json_decode($result);
    }    
}
function getRegionFromAddress()
{
	$is_bot = preg_match(
	 "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", 
	 $_SERVER['HTTP_USER_AGENT']
	);
	// получаем данные юр.лица по ИНН
	$token = '49d6bfad5748ee681d9e571384ebb5f9a2be0f71';
	$dadata = new Suggestions($token);
	$query = '7702680818';
	$data = array(
		'query' => $query
	);
	$resp = $dadata->suggest("party", $data);

	// название компании
	//print 'Название: ' . $resp->suggestions[0]->value . "<br/>\n";


	// получаем данные юр.лица по ИНН
	$token = '49d6bfad5748ee681d9e571384ebb5f9a2be0f71';
	$dadata = new Suggestions($token);
	$query = 'Люблинская 76';
	$data = array(
		'query' => $query
	);
	$resp = $dadata->suggest("address", $data);

	// название компании
	//print 'Название: ' . $resp->suggestions[0]->value . "<br/>\n";

	// получаем данные по адресу
	$token = '49d6bfad5748ee681d9e571384ebb5f9a2be0f71';
	$dadata = new Suggestions($token);
	$query = 'Люблинская 76';
	$data = array(
		'query' => $query
	);
	$resp = $dadata->suggest("address", $data);

	// Адрес
	//return 'Адресс: ' . $resp->suggestions[0]->value . "<br/>\n";
	

	//return $resp->suggestions[0]->data->region_with_type;
	return !$is_bot ? $dadata->suggest("address", $data)->suggestions[0]->data->region_with_type:[];
}
// https://10.222.222.93/app/importexport/getData.php?key=1q2w3e!QWE!&art=id
function gpc($url='https://10.222.222.92/app/importexport/getData.php')
{
	$auth = base64_encode('admin:Kmr-bYp-CkW-sS2');
 
	$post = array(	
		'key'  => '1q2w3e!QWE!',
		'art' => 'id'
	);
	 
	$headers = stream_context_create(
		array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL . 
							 'Authorization: Basic ' . $auth,
				'content' => http_build_query($post),
			)
		)
	);
	 
	return @file_get_contents($url, false, $headers);
}

		
function curl_da($url='https://10.222.222.92/app/importexport/getData.php') 
{
	$data = array(
	'key'  => '1q2w3e!QWE!',
	'art' => 'id'
	);
	$ch = curl_init('$url');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
	 
	$res = json_encode($res, JSON_UNESCAPED_UNICODE);
	return $res;

}
function executeHook($params) 
{

    $queryUrl = 'https://10.222.222.92/rest/1/udar3tjicfcv3pm6/batch.json';
    $queryData = http_build_query($params);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = curl_exec($curl);
    curl_close($curl);

    return json_decode($result, true);

}
function check_artikul ($articul) 
{

	$queryUrl = 'https://10.222.222.92/rest/1/udar3tjicfcv3pm6/crm.product.list.json';
	//echo $queryUrl . '<br>';
	$now = new DateTime();
	$params = array(
		'order' => array( 'BEGINDATE' => 'DESC' ),
		'FILTER' => array(
			//'>BEGINDATE' => $now->modify('-7 day')->format('d.m.Y H:i:s'),
			'CATEGORY_ID' => 14,
            'XML_ID' => $articul			
		),
		'select' => array(			
			'XML_ID'
		),

	); 
	$queryData = http_build_query($params);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = json_decode(curl_exec($curl),true);
    curl_close($curl);

	return (!isset($result['error']) or empty($result['error']))? $result['result']: $result['error'];
}

echo '<pre>';

function get_status()
{
	
	$statusResult = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
		'order' => array('STATUS.SORT'=>'ASC'),
		'filter' => array('STATUS.TYPE'=>'O','LID'=>LANGUAGE_ID),
		'select' => array('STATUS_ID','NAME','DESCRIPTION'),
	));
	while($arStatus = $statusResult->fetch()){
		print_r($arStatus);  //STATUS_ID, NAME (на нужном языке),DESCRIPTION (на нужном языке)
	}
		//return $statusResult;
}







if (CModule::IncludeModule("iblock"))
{

	$iblock_id = 6;
	$my_elements = CIBlockElement::GetList (
		Array("ID" => "ASC"),
		Array("IBLOCK_ID" => $iblock_id),
		false,
		false,
		Array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE')
	);

	while($ar_fields = $my_elements->GetNext())
	{
		//echo $ar_fields['PREVIEW_PICTURE']." <br>";
		$img_path = CFile::GetPath($ar_fields["PREVIEW_PICTURE"]);
		$sku = CFile::GetPath($ar_fields["NAME"]);
		echo $img_path." <br>";
	}

}




//=========================================================================
	
	echo var_dump(get_status());
	
	/*
	$array = array(
		'login'    => 'admin',
		'password' => 'Kmr-bYp-CkW-sS2'
	);		
	 
	$ch = curl_init('https://10.222.222.92/app/importexport/getData.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$html = curl_exec($ch);
	curl_close($ch);
	echo $html;
	*/
//=========================================================================



echo '</pre>'
/*
$is_bot = preg_match(
 "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i", 
 $_SERVER['HTTP_USER_AGENT']
);
$geo = !$is_bot ? json_decode(file_get_contents('http://api.sypexgeo.net/json/'), true) : [];
echo '<pre>';
var_dump($geo['region']['name_ru']);
echo '</pre>';
*/


//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_after.php'); 
?>