<?
//define('C_REST_CLIENT_ID','local.');//Application ID
//define('C_REST_CLIENT_SECRET','SakeVG5mbRdcQet45UUrt6');//Application key
// or
$key = 'udar3tjicfcv3pm6';
define('C_REST_WEB_HOOK_URL','https://10.222.222.92/rest/1/'.$key.'/');//url on creat Webhook

//define('C_REST_CURRENT_ENCODING','windows-1251');
define('C_REST_IGNORE_SSL',true);//turn off validate ssl by curl
define('C_REST_LOG_TYPE_DUMP',true); //logs save var_export for viewing convenience
define('C_REST_BLOCK_LOG',true);//turn off default logs
define('C_REST_LOGS_DIR', __DIR__ .'/logs/'); //directory path to save the log