<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->AddChainItem("Страница не найдена", "");
$APPLICATION->SetTitle("Страница не найдена | ТрансСтройБанк");
$APPLICATION->SetPageProperty("description", "Данная страница не найдена. Вернитесь на главную страницу сайта по продаже инвестиционных и юбилейных монет ТрансСтройБанк");?>

<style>
body main
{
    padding-bottom: 40px;
}
.breadcrumbs-nav {
    display: none;
}

.main-inner-wrapper-404
{
    width: 100%;
    height: 100%;

    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
    align-items: center;
}

.avatar-404
{
    margin-bottom: 60px;
    max-width: 481px;
}
@media screen and (max-width: 960px) 
{
    .avatar-404
    {
        margin-bottom: 103px;
    }
}
@media screen and (max-width: 720px) 
{
    .avatar-404
    {
        max-width: 100%;
        margin-bottom: 40px;
    }
}

.to-catalog
{
    margin-top: 80px;
}
@media screen and (max-width: 1140px) 
{
    .to-catalog
    {
        margin-top: 52px;
    }
}
@media screen and (max-width: 960px) 
{
    .to-catalog
    {
        margin-top: 30px;

        padding-top: 18px;
        padding-bottom: 18px;
    }
}
@media screen and (max-width: 720px) 
{
    .to-catalog
    {
        margin-top: 20px;
    }
}
</style>

<div class="content-container">
    <div class="main-inner-wrapper-404">
        <img src="/upload/mm_upload/404.png" alt="404" class="avatar-404">

        <p class="404-message heading-3">Страница не найдена</p>

        <a href="/katalog/" class="to-catalog mint-btn filled mini">Каталог</a>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>