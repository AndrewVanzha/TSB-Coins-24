<?php

use Bitrix\Main;
use \Bitrix\Sale;
use \Bitrix\Sale\Order;

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    'sale', 
    'OnSaleOrderSaved', 
	['ExportToB24', 'exportOrder']

); 

$eventManager->addEventHandler(
    'sale',	
    'OnSaleStatusOrderChange',	
	['UpdateStatusB24', 'updateOrder']

);

unset($eventManager);


AddEventHandler("main", "OnBuildGlobalMenu", "AddReportMenus");
function AddReportMenus(&$adminMenu, &$moduleMenu){
    $moduleMenu[] = array(
        "parent_menu" => "global_menu_services",
        "section"     => "Генератор отчетов по заказам",
        "sort"        => 1000,
        "url"         => "/reports/sale_report/admin_step.php",//home/bitrix/www/reports/sale_report/admin_step.php
        "text"        => 'Генератор отчетов по заказам',
        "title"       => '',
        "icon"        => "form_menu_icon",
        "page_icon"   => "form_page_icon",
        "items_id"    => "",
        "items"       => array()

    );
}


// организовать поиск только по названиям
AddEventHandler("search", "BeforeIndex", array("SearchHandlers", "BeforeIndexHandler"));
class SearchHandlers
{
    function BeforeIndexHandler($arFields)
    {
        if($arFields["MODULE_ID"] == "iblock")
        {
            if(array_key_exists("BODY", $arFields) && substr($arFields["ITEM_ID"], 0, 1) != "S") // Только для элементов
            {
                $arFields["BODY"] = "";
            }

            if (substr($arFields["ITEM_ID"], 0, 1) == "S") // Только для разделов
            {
                $arFields['TITLE'] = "";
                $arFields["BODY"] = "";
                $arFields['TAGS'] = "";
            }
        }

        return $arFields;
    }
}

?>