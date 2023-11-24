<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.search", 
	"search.mm", 
	array(
		"ACTION_VARIABLE" => "action",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "6",
		"IBLOCK_TYPE" => "catalog",
		"LINE_ELEMENT_COUNT" => "3",
		"NO_WORD_LOGIC" => "N",
		"OFFERS_LIMIT" => "5",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "mm_nav-loadmore",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "5",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(
			0 => "RELEASE_YEAR",
			1 => "METAL",
			2 => "PROBA",
			3 => "QUALITY",
			4 => "",
		),
		"RESTART" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SHOW_PRICE_COUNT" => "1",
		"USE_LANGUAGE_GUESS" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "search.mm"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>