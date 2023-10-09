<div class="contacts-row-item contacts">
    <h2 class="heading-4 contacts-row-item__name">Контакты</h2>
    
    <div class="contacts-row-item__email-tel">
        <?/*--- Телефон ---*/?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/local/include/phone.php",
                "CUSTOM_SVG" => "tel",
            )
        );?>
        
        <?/*--- Email ---*/?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/local/include/email.php",
                "CUSTOM_SVG" => "tel",
            )
        );?>
    </div>

    <div class="contacts-row-item__socials">
        <?/*--- Facebook ---*/?>
        <?/*$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/local/include/socials/facebook_social.php"
            )
        );*/?>

        <?/*--- Vk ---*/?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/local/include/socials/vk_social.php",
                "CUSTOM_SVG" => "tel",
            )
        );?>

        <?/*--- Instagram ---*/?>
        <?/*$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/local/include/socials/instagram_social.php"
            )
        );*/?>
    </div>
</div>