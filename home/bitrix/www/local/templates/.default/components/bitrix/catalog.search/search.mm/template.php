<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$this->addExternalCss('/local/templates/mm_main/assets/css/components/catalog-section-list.css');
//$APPLICATION->ShowViewContent('formSearch');
?>
<?
$this->SetViewTarget("formSearch");
    $arElements = $APPLICATION->IncludeComponent(
    	"bitrix:search.page",
    	"",
    	Array(
    		"AJAX_MODE" => "N",
    		"AJAX_OPTION_ADDITIONAL" => "N",
    		"AJAX_OPTION_HISTORY" => "N",
    		"AJAX_OPTION_JUMP" => "N",
    		"AJAX_OPTION_SHADOW" => "Y",
    		"AJAX_OPTION_STYLE" => "N",
    		"CACHE_TIME" => "36000000",
    		"CACHE_TYPE" => "N",
    		"CHECK_DATES" => "N",
    		"DEFAULT_SORT" => "rank",
    		"DISPLAY_BOTTOM_PAGER" => "N",
    		"DISPLAY_TOP_PAGER" => "N",
    		"FILTER_NAME" => "",
    		"NO_WORD_LOGIC" => "N",
    		"PAGER_SHOW_ALWAYS" => "Y",
    		"PAGER_TEMPLATE" => ".default",
    		"PAGER_TITLE" => "Результаты поиска",
    		"PAGE_RESULT_COUNT" => "50",
    		"PATH_TO_USER_PROFILE" => "",
    		"RATING_TYPE" => "",
    		"RESTART" => "Y",
    		"SHOW_ITEM_DATE_CHANGE" => "N",
    		"SHOW_ITEM_TAGS" => "N",
    		"SHOW_ORDER_BY" => "N",
    		"SHOW_RATING" => "",
    		"SHOW_TAGS_CLOUD" => "N",
    		"SHOW_WHEN" => "N",
    		"SHOW_WHERE" => "Y",
    		"USE_LANGUAGE_GUESS" => "N",
    		"USE_SUGGEST" => "Y",
    		"USE_TITLE_RANK" => "N",
    		"arrFILTER" => array("no"),
    		"arrFILTER_iblock_catalog" => array("all"),
    		"arrFILTER_iblock_news" => array("all"),
    		"arrFILTER_iblock_services" => array("all"),
    		"arrFILTER_main" => array(""),
    		"arrWHERE" => array("iblock_catalog","iblock_content")
    	),
		$component,
		array('HIDE_ICONS' => 'Y')
    );
$this->EndViewTarget();

$price_sort_desc = 'catalog_PRICE_1-desc';
$price_sort_asc = 'catalog_PRICE_1-asc';

#варианты сортировки
$arSorts = array(
    "sort-desc"                 => "По умолчанию",
    "shows-desc"                => "По популярности",
    $price_sort_desc            => "По цене (дороже)",
    $price_sort_asc             => "По цене (дешевле)",
    "name-asc"                  => "По названию (возр.)",
    "name-desc"                 => "По названию (убыв.)",
);

$sort = array_key_exists( $_REQUEST["sort"], $arSorts ) ? $_REQUEST["sort"] : "sort-desc";
$sort_masiv = explode("-", $sort);

$arParams["SORTS"] = array();

if(count($arSorts) > 0) {
    foreach($arSorts as $key => $value){

        $sort_variant = array(
            "CODE"   => $key,
            "NAME"   => $value,
            "LABEL"  => $value,
            "ACTIVE" => $key == $sort_masiv[0].'-'.$sort_masiv[1] ? "Y" : "N"
        );
        $sort_variant["LINK"] = $APPLICATION->GetCurPageParam(
            "sort=".$key,array("sort")
        );

        $arParams["SORTS"][] = $sort_variant;
    }
}

?>
<div class="content-container">
<?
if (!empty($arElements) && is_array($arElements))
{?>
	<h1 class="heading-1 catalog-section-name"><?$APPLICATION->ShowTitle(false);?></h1>
	<section class="section-tabs-sort-wrapper">
        <div class="catalog-sections-tabs">

        </div>  

        <div class="catalog-sort">
            <select 
            name="sort-product" 
            id="sort-product" 
            class="sort-type-select">
                <?foreach ($arParams["SORTS"] as $key => $sort):?>
                    <option 
                    <?=$sort["ACTIVE"] == 'Y' ? 'selected' : '';?>
                    value="<?=$sort["LINK"]?>"
                    ><?=$sort["LABEL"]?></option>
                <?endforeach;?>
            </select>
            <script>
                $( "#sort-product" ).change(function() {
                    window.location = $(this).val();
                });
            </script>

            <div class="render-options">
                <button 
                class="render-options__button <?= ( ($_COOKIE['view'] == "list") ? 'active' : '')?>" 
                data-render-type="list">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_2_5915)">
                            <path d="M17.1027 15.5366H5.06613C4.57004 15.5366 4.16797 15.1345 4.16797 14.6384C4.16797 14.1423 4.57004 13.7402 5.06613 13.7402H17.1024C17.5984 13.7402 18.0005 14.1423 18.0005 14.6384C18.0005 15.1345 17.5987 15.5366 17.1027 15.5366Z"/>
                            <path d="M17.1027 9.89788H5.06613C4.57004 9.89788 4.16797 9.4958 4.16797 8.99972C4.16797 8.50364 4.57004 8.10156 5.06613 8.10156H17.1024C17.5984 8.10156 18.0005 8.50364 18.0005 8.99972C18.0008 9.4958 17.5987 9.89788 17.1027 9.89788Z"/>
                            <path d="M17.1027 4.26116H5.06613C4.57004 4.26116 4.16797 3.85909 4.16797 3.363C4.16797 2.86692 4.57004 2.46484 5.06613 2.46484H17.1024C17.5984 2.46484 18.0005 2.86692 18.0005 3.363C18.0005 3.85909 17.5987 4.26116 17.1027 4.26116Z"/>
                            <path d="M1.20623 4.63902C1.87241 4.63902 2.41245 4.09897 2.41245 3.43279C2.41245 2.76661 1.87241 2.22656 1.20623 2.22656C0.540046 2.22656 0 2.76661 0 3.43279C0 4.09897 0.540046 4.63902 1.20623 4.63902Z" />
                            <path d="M1.20623 10.2054C1.87241 10.2054 2.41245 9.66538 2.41245 8.9992C2.41245 8.33301 1.87241 7.79297 1.20623 7.79297C0.540046 7.79297 0 8.33301 0 8.9992C0 9.66538 0.540046 10.2054 1.20623 10.2054Z" />
                            <path d="M1.20623 15.7757C1.87241 15.7757 2.41245 15.2357 2.41245 14.5695C2.41245 13.9033 1.87241 13.3633 1.20623 13.3633C0.540046 13.3633 0 13.9033 0 14.5695C0 15.2357 0.540046 15.7757 1.20623 15.7757Z" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2_5915">
                            <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </button>

                <button 
                class="render-options__button <?= ( ($_COOKIE['view'] == "table" || empty($_COOKIE['view'])) ? 'active' : '')?>" 
                data-render-type="grid">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.21534 0H2.08153C0.933785 0 0 0.933785 0 2.08153V6.21534C0 7.36309 0.933785 8.29688 2.08153 8.29688H6.21534C7.36309 8.29688 8.29688 7.36309 8.29688 6.21534V2.08153C8.29688 0.933785 7.36309 0 6.21534 0ZM6.89062 6.21534C6.89062 6.58768 6.58768 6.89062 6.21534 6.89062H2.08153C1.70919 6.89062 1.40625 6.58768 1.40625 6.21534V2.08153C1.40625 1.70919 1.70919 1.40625 2.08153 1.40625H6.21534C6.58768 1.40625 6.89062 1.70919 6.89062 2.08153V6.21534Z"/>
                        <path d="M15.8906 0H11.8125C10.6494 0 9.70312 0.946266 9.70312 2.10938V6.1875C9.70312 7.35061 10.6494 8.29688 11.8125 8.29688H15.8906C17.0537 8.29688 18 7.35061 18 6.1875V2.10938C18 0.946266 17.0537 0 15.8906 0ZM16.5938 6.1875C16.5938 6.5752 16.2783 6.89062 15.8906 6.89062H11.8125C11.4248 6.89062 11.1094 6.5752 11.1094 6.1875V2.10938C11.1094 1.72167 11.4248 1.40625 11.8125 1.40625H15.8906C16.2783 1.40625 16.5938 1.72167 16.5938 2.10938V6.1875Z"/>
                        <path d="M6.21534 9.29688H2.08153C0.933785 9.29688 0 10.2307 0 11.3784V15.5122C0 16.66 0.933785 17.5938 2.08153 17.5938H6.21534C7.36309 17.5938 8.29688 16.66 8.29688 15.5122V11.3784C8.29688 10.2307 7.36309 9.29688 6.21534 9.29688ZM6.89062 15.5122C6.89062 15.8846 6.58768 16.1875 6.21534 16.1875H2.08153C1.70919 16.1875 1.40625 15.8846 1.40625 15.5122V11.3784C1.40625 11.0061 1.70919 10.7031 2.08153 10.7031H6.21534C6.58768 10.7031 6.89062 11.0061 6.89062 11.3784V15.5122Z" />
                        <path d="M15.8906 9.29688H11.8125C10.6494 9.29688 9.70312 10.2431 9.70312 11.4062V15.4844C9.70312 16.6475 10.6494 17.5938 11.8125 17.5938H15.8906C17.0537 17.5938 18 16.6475 18 15.4844V11.4062C18 10.2431 17.0537 9.29688 15.8906 9.29688ZM16.5938 15.4844C16.5938 15.8721 16.2783 16.1875 15.8906 16.1875H11.8125C11.4248 16.1875 11.1094 15.8721 11.1094 15.4844V11.4062C11.1094 11.0185 11.4248 10.7031 11.8125 10.7031H15.8906C16.2783 10.7031 16.5938 11.0185 16.5938 11.4062V15.4844Z"/>
                    </svg>
                </button>

            </div>

        </div>
    </section>
	<?
	global $searchFilter;
	$searchFilter = array(
		"=ID" => $arElements,
	);

	$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		"mm.products_delayed",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => !empty($sort_masiv[0])?$sort_masiv[0]:"sort",
			"ELEMENT_SORT_FIELD2" => "",
			"ELEMENT_SORT_ORDER" => count($sort_masiv)>1?$sort_masiv[1]:"desc",
			"ELEMENT_SORT_ORDER2" => "",
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
			"SECTION_URL" => $arParams["SECTION_URL"],
			"DETAIL_URL" => "/katalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
			"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
			"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arParams["CURRENCY_ID"],
			"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"FILTER_NAME" => "searchFilter",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"SORTS_SHOW_ELEMENTS" => $arSorts,
			"SECTION_USER_FIELDS" => array(),
			"INCLUDE_SUBSECTIONS" => "Y",
			"SHOW_ALL_WO_SECTION" => "Y",
			"META_KEYWORDS" => "",
			"META_DESCRIPTION" => "",
			"BROWSER_TITLE" => "",
			"ADD_SECTIONS_CHAIN" => "N",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			"FULL_SIZE" => "Y",
			"TOP_WRAPPER" => 'Y'
		),
		$arResult["THEME_COMPONENT"],
		array('HIDE_ICONS' => 'Y')
	);
	?>
	
<?}
elseif (is_array($arElements))
{
	echo GetMessage("CT_BCSE_NOT_FOUND");
}
?>
</div>
