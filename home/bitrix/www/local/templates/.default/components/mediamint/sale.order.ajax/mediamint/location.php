<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
?>

<?foreach ($arResult["ORDER_PROP"]["USER_PROPS_Y"] as $k => $v):?>
	<?if($v["PROPS_GROUP_ID"] == 3):?>
        <? if ($v['NAME'] == 'Индекс') { // пропускаю поле Индекс
            continue;
        } ?>
		<?$location[$v["ID"]] = $v;?>
		<?if (array_key_exists($v["ID"], $arResult["ERROR"])):?>
			<?$location[$v["ID"]]["ERROR"] = $arResult["ERROR"][$v["ID"]];?>
		<?endif;?>
	<?endif;?>
<?endforeach;?>

<?foreach ($arResult["ORDER_PROP"]["USER_PROPS_N"] as $k => $v):?>
	<?if($v["PROPS_GROUP_ID"] == 3):?>
		<?$location[$v["ID"]] = $v;?>
		<?if (array_key_exists($v["ID"], $arResult["ERROR"])):?>
			<?$location[$v["ID"]]["ERROR"] = $arResult["ERROR"][$v["ID"]];?>
		<?endif;?>
	<?endif;?>
<?endforeach;?>

<?usort($location, function($a, $b){
	return ($a['SORT'] - $b['SORT']);
});?>

<?php
$arLocalShops = [];
if (\Bitrix\Main\Loader::includeModule('sale')) {
    $moscow_id = 129;
    if ($_REQUEST['ORDER_PROP_6']) {
        $location_id = $_REQUEST['ORDER_PROP_6'];
    } else {
        $location_id = $moscow_id;
    }
    //debugg('$location_id');
    //debugg($location_id);
    $res = \Bitrix\Sale\Location\LocationTable::getList(array(
        'filter' => array(
            '=ID' => $location_id,
            '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
        ),
        'select' => array(
            '*',
            'NAME_RU' => 'NAME.NAME',
            'TYPE_CODE' => 'TYPE.CODE'
        ),
    ));
    while($item = $res->fetch()) { // выбранный город для shops.php
        $arResult["CITY_PLACE"]['ID'] = $item['CITY_ID'];
        $arResult["CITY_PLACE"]['VALUE'] = $item['NAME_RU'];
        $arResult["CITY_PLACE"]['TYPE'] = $item['TYPE_CODE'];  // CITY
    }
    //debugg($arResult["CITY_PLACE"]);

// Инфоблок 23 Адреса магазинов:
// добавить символьный код API shopAddresses
// добавить свойство Город / ATT_CITY (Строка)
// заполнить свойство Город во всех элементах инфоблока
// делаю список городов, где есть магазины
    $elements = \Bitrix\Iblock\Elements\ElementShopAddressesTable::getList([ // API = ShopAddresses
        'select' => ['ID', 'NAME', 'ATT_CITY', 'SORT'],
        'filter' => [
            '=ACTIVE' => 'Y',
            'IBLOCK_ID' => 23,
        ],
        'order' => ['SORT' => 'ASC'],
    ])->fetchAll();
    foreach ($elements as $key=>$element) {
        if ($element['IBLOCK_ELEMENTS_ELEMENT_SHOP_ADDRESSES_ATT_CITY_VALUE']) {
            $el_city['ID'] = $element['ID'];
            $el_city['CITY'] = $element['IBLOCK_ELEMENTS_ELEMENT_SHOP_ADDRESSES_ATT_CITY_VALUE'];
            $el_city['ADDRESS'] = $element['NAME'];
            $arResult['CITY_ADDRESSES'][] = $el_city;
        }
    }
}
//debugg($location);
?>

<div class = "ajorder-section">
	<h4 class = "ajorder-section_header">Регион доставки</h4>
	<div class = "ajorder-section-inner">
		<div class = "ajorder-flex-inputs">
			<?PrintPropsForm($location, $arParams["TEMPLATE_LOCATION"]);?>
		</div>
		<div class = "ajorder-section-after_text">
			Выберите свой город в списке. Если вы не нашли свой город, выберите "Другое местоположение", а город впишите в комментарий к заказу. Наши менеджеры свяжутся с вами и рассчитают стоимость доставки.
		</div>
	</div>
</div>
