<?php


/**
 * Используйте эти классы, если не умеете или не хотите работать с `composer`
 * и использовать библиотеку [dadata-php](https://github.com/hflabs/dadata-php/).
 * 
 * Классы не имеют внешних зависимостей, кроме `curl`. Примеры вызова внизу файла.
 */

class TooManyRequests extends Exception
{
}

class Dadata
{
    private $clean_url = "https://cleaner.dadata.ru/api/v1/clean";
    private $suggest_url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs";
    private $token="";
    private $secret="";
    private $handle="";

    public function __construct($token, $secret)
    {
        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * Initialize connection.
     */
    public function init()
    {
        $this->handle = curl_init();
		curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Token " . $this->token,
            "X-Secret: " . $this->secret,
        ));
        curl_setopt($this->handle, CURLOPT_POST, 1);
    }

    /**
     * Clean service.
     * See for details:
     *   - https://dadata.ru/api/clean/address
     *   - https://dadata.ru/api/clean/phone
     *   - https://dadata.ru/api/clean/passport
     *   - https://dadata.ru/api/clean/name
     * 
     * (!) This is a PAID service. Not included in free or other plans.
     */
    public function clean($type, $value)
    {
        $url = $this->clean_url . "/$type";
        $fields = array($value);
        return $this->executeRequest($url, $fields);
    }

    /**
     * Find by ID service.
     * See for details:
     *   - https://dadata.ru/api/find-party/
     *   - https://dadata.ru/api/find-bank/
     *   - https://dadata.ru/api/find-address/
     */
    public function findById($type, $fields)
    {
        $url = $this->suggest_url . "/findById/$type";
        return $this->executeRequest($url, $fields);
    }

    /**
     * Reverse geolocation service.
     * See https://dadata.ru/api/geolocate/ for details.
     */
    public function geolocate($lat, $lon, $count = 10, $radius_meters = 100)
    {
        $url = $this->suggest_url . "/geolocate/address";
        $fields = array(
            "lat" => $lat,
            "lon" => $lon,
            "count" => $count,
            "radius_meters" => $radius_meters
        );
        return $this->executeRequest($url, $fields);
    }

    /**
     * Detect city by IP service.
     * See https://dadata.ru/api/iplocate/ for details.
     */
    public function iplocate($ip)
    {
        $url = $this->suggest_url . "/iplocate/address";
        $fields = array(
            "ip" => $ip
        );
        return $this->executeRequest($url, $fields);
    }

    /**
     * Suggest service.
     * See for details:
     *   - https://dadata.ru/api/suggest/address
     *   - https://dadata.ru/api/suggest/party
     *   - https://dadata.ru/api/suggest/bank
     *   - https://dadata.ru/api/suggest/name
     *   - ...
     */
    public function suggest($type, $fields)
    {
        $url = $this->suggest_url . "/suggest/$type";
        return $this->executeRequest($url, $fields);
    }

    /**
     * Close connection.
     */
    public function close()
    {
        curl_close($this->handle);
    }

    private function executeRequest($url, $fields)
    {   
		
        curl_setopt($this->handle, CURLOPT_URL, $url);
        if ($fields != null) {
            curl_setopt($this->handle, CURLOPT_POST, 1);
            curl_setopt($this->handle, CURLOPT_POSTFIELDS, json_encode($fields));
        } else {
            curl_setopt($this->handle, CURLOPT_POST, 0);
        }
        $result = $this->exec();
        $result = json_decode($result, true);
        return $result;
    }

    private function exec()
    {
        $result = curl_exec($this->handle);
        $info = curl_getinfo($this->handle);
        if ($info['http_code'] == 429) {
            throw new TooManyRequests();
        } elseif ($info['http_code'] != 200) {
            throw new Exception('Request failed with http code ' . $info['http_code'] . ': ' . $result);
        }
        return $result;
    }
}
/*
class Dadata {
    public function __construct($apiKey, $secretKey) {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }
    public function clean($type, $data) {
        $requestData = array($data);
        return $this->executeRequest('https://dadata.ru/api/v2/clean/' . $type, $requestData);
    }
    public function cleanRecord($structure, $record) {
        $requestData = array(
          'structure' => $structure,
          'data' => array($record)
        );
        return $this->executeRequest('https://dadata.ru/api/v2/clean', $requestData);
    }
	
    private function prepareRequest($curl, $data) {
        // отключить проверку SSL-сертификата
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // или скачать сертификат здесь https://curl.haxx.se/docs/caextract.html
        curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__).'/cacert.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'Accept: application/json',
             'Authorization: Token ' . $this->apiKey,
             'X-Secret: ' . $this->secretKey,
          ));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }
    private function executeRequest($url, $data) {
        $result = false;
        if ($curl = curl_init($url)) {
            $this->prepareRequest($curl, $data);
            $result = curl_exec($curl);
            if (curl_errno($curl)) { 
                echo 'Error: ' . curl_error($curl);
            }
            $result = json_decode($result, true);
            curl_close($curl);
        }
        return $result;
    }
}
*/
/*
//Пример использования
$apiKey = 'API_KEY';
$secretKey = 'SECRET_KEY';
$dadata = new Dadata($apiKey, $secretKey);

// Стандартизация одного значения конкретного типа
$result = $dadata->clean('name', 'Сергей Владимерович Иванов');
print_r($result);
*/
//ВЫВОД:
/*
Array
(
    [0] => Array
        (
            [source] => Сергей Владимерович Иванов
            [result] => Иванов Сергей Владимирович
            [result_genitive] => Иванова Сергея Владимировича
            [result_dative] => Иванову Сергею Владимировичу
            [result_ablative] => Ивановым Сергеем Владимировичем
            [surname] => Иванов
            [name] => Сергей
            [patronymic] => Владимирович
            [gender] => М
            [qc] => 1
        )
)
*/
/*
// Стандартизация нескольких значений одного типа; допускается
// не более 1 ФИО, 3 адресов, 3 телефонов, 3 email
$structure = array('PHONE', 'ADDRESS');
$record = array('8 916 823 3454', 'Москва, 3 пр. Перова поля, д. 8 стр.11');
$result = $dadata->cleanRecord($structure, $record);
print_r($result);
*/
/*
Array
(
    [structure] => Array
        (
            [0] => PHONE
            [1] => ADDRESS
        )
    [data] => Array
        (
            [0] => Array
                (
                    [0] => Array
                        (
                            [source] => 8 916 823 3454
                            [type] => Мобильный
                            [phone] => +7 916 823-34-54
                            [country_code] => 7
                            [city_code] => 916
                            [number] => 8233454
                            [extension] =>
                            [provider] => ПАО "Мобильные ТелеСистемы"
                            [region] => Москва и Московская область
                            [timezone] => UTC+3
                            [qc_conflict] => 0
                            [qc] => 0
                        )
                    [1] => Array
                        (
                            [source] => Москва, 3 пр. Перова поля, д. 8 стр.11
                            [result] => г Москва, проезд Перова Поля 3-й, д 8 стр 11
                            [postal_code] => 111141
                            [country] => Россия
                            [region_fias_id] => 0c5b2444-70a0-4932-980c-b4dc0d3f02b5
                            [region_kladr_id] => 7700000000000
                            [region_with_type] => г Москва
                            [region_type] => г
                            [region_type_full] => город
                            [region] => Москва
                            [area_fias_id] =>
                            [area_kladr_id] =>
                            [area_with_type] =>
                            [area_type] =>
                            [area_type_full] =>
                            [area] =>
                            [city_fias_id] =>
                            [city_kladr_id] =>
                            [city_with_type] =>
                            [city_type] =>
                            [city_type_full] =>
                            [city] =>
                            [city_area] => Восточный
                            [city_district_fias_id] =>
                            [city_district_kladr_id] =>
                            [city_district_with_type] => р-н Перово
                            [city_district_type] => р-н
                            [city_district_type_full] => район
                            [city_district] => Перово
                            [settlement_fias_id] =>
                            [settlement_kladr_id] =>
                            [settlement_with_type] =>
                            [settlement_type] =>
                            [settlement_type_full] =>
                            [settlement] =>
                            [street_fias_id] => 72a95d02-f1fd-474e-a566-1c96c207526d
                            [street_kladr_id] => 77000000000042900
                            [street_with_type] => проезд Перова Поля 3-й
                            [street_type] => проезд
                            [street_type_full] => проезд
                            [street] => Перова Поля 3-й
                            [house_fias_id] => b6305b5f-e327-43df-8218-838fdfb1756b
                            [house_kladr_id] => 7700000000004290036
                            [house_type] => д
                            [house_type_full] => дом
                            [house] => 8
                            [block_type] => стр
                            [block_type_full] => строение
                            [block] => 11
                            [flat_type] =>
                            [flat_type_full] =>
                            [flat] =>
                            [flat_area] =>
                            [square_meter_price] =>
                            [flat_price] =>
                            [postal_box] =>
                            [fias_id] => b6305b5f-e327-43df-8218-838fdfb1756b
                            [fias_code] => 77000000000000004290036
                            [fias_level] => 8
                            [fias_actuality_state] => 0
                            [kladr_id] => 7700000000004290036
                            [capital_marker] => 0
                            [okato] => 45263583000
                            [oktmo] => 45312000
                            [tax_office] => 7720
                            [tax_office_legal] => 7720
                            [timezone] => UTC+3
                            [geo_lat] => 55.7525456
                            [geo_lon] => 37.7718395
                            [beltway_hit] => IN_MKAD
                            [beltway_distance] =>
                            [qc_geo] => 0
                            [qc_complete] => 5
                            [qc_house] => 2
                            [qc] => 0
                            [unparsed_parts] =>
                            [metro] => Array
                                (
                                    [0] => Array
                                        (
                                            [distance] => 0.8
                                            [line] => Калининско-Солнцевская
                                            [name] => Перово
                                        )
                                    [1] => Array
                                        (
                                            [distance] => 1.4
                                            [line] => Калининско-Солнцевская
                                            [name] => Шоссе Энтузиастов
                                        )
                                    [2] => Array
                                        (
                                            [distance] => 1.6
                                            [line] => МЦК
                                            [name] => Шоссе Энтузиастов
                                        )
                                )
                        )
                )
        )
)
*/
?>