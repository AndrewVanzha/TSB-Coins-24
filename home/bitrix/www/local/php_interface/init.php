<?php
foreach( [
    /**
     * File for other kernel data:
     *    Service local integration
     *    Env file with local variables
     *        external service credentials
     *        feature enable flags
     */
    __DIR__.'/kernel.php',
	
	/**
     * Classes loader subscribe
     */
    __DIR__.'/autoload.php',

    /**
     * Events subscribe
     */
    __DIR__.'/events.php',

    /**
     * Include composer libraries
     */
    __DIR__.'/vendor/autoload.php',

    /**
     * Include old legacy code
     *   constant initiation etc
     */
    __DIR__.'/legacy.php',
	
	
	/**
     * Castom portal subscribe
     */
	__DIR__ . '/workflow/custom_portal.php',
    ]
    as $filePath )
{
    if ( file_exists($filePath) )
    {
        require_once($filePath);
    }
}
unset($filePath);

//перенес в events.php
/*
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
*/

//это можно перенести в папку include
if (!function_exists("debugg")) {
    function debugg($data)
    {
        global $USER;
        if($USER->GetID() == 3814) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
}

//  функция объявлена потому, что на 404 вылезала ошибка
/*
call_user_func_array(): Argument #1 ($callback) must be a valid callback, function "ShowCanonical" not found or invalid function name (0)
..../public_html/bitrix/modules/main/classes/general/main.php:3195
*/
if (!function_exists("ShowCanonical")) {
  function ShowCanonical() {
    return "";
//    global $APPLICATION;
//    $APPLICATION->AddBufferContent('GetCanonical');
  }
}
?>