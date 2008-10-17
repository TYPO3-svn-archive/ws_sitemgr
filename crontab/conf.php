<? 
$conf['svn_server'] = "https://svn.wildside.dk:4443";
$conf['svn_server_file'] = "file:///svn";
$conf['svn_user'] = "sitemgr";
$conf['svn_pass'] = "rth8slJ89";
$conf['svn_hoteldir'] = "/typo3/hoteller/";
$conf['svn_deletedfolder'] = "deleted/";

$conf['svn_templateversion'] = "1.0.0.0";

$conf['svn_baseurlfile_dir'] = "fileadmin/templates/TS/setup/";
$conf['svn_baseurlfile'] = "baseurl.txt";

$conf['dir_test'] = "/var/www/typo3/hoteller/"; // Path to TEST hotel - in most cases used for test of everything together before put to production
$conf['dir_test_docs'] = "/htdocs/";
$conf['dir_test_rights'] = "www-data:www-data";

$conf['dir_dev'] = "/var/www/dev/developers/"; // Path to DEV hotels - where alle the developer have their own versions of hotels
$conf['dir_dev_docs'] = "/htdocs/";
$conf['dir_dev_rights'] = "www-data:developers";

$conf['dir_prod_rights'] = "www-data:developers";



//$conf['ignoreFolders'][] = "fileadmin/_temp_/";
//$conf['ignoreFolders'][] = "fileadmin/user_upload/";
//$conf['ignoreFolders'][] = "typo3temp/";
//$conf['ignoreFolders'][] = "uploads/";

$conf['mysqldumpFileName'] = "mysqldump.sql";

$conf['database_dev_host'] = "localhost";
$conf['database_dev_user'] = "root";
$conf['database_dev_pass'] = "sl56qpsql";
$conf['database_prefix'] = "t3_";

$conf['database_production_host'] = "localhost";
$conf['database_production_user'] = "root";
$conf['database_production_pass'] = "sl56qpsql";


$conf['t3_hotel_sysfolder'] = 3;
$conf['t3_hotel_sysfolder_deleted'] = 4;
$conf['t3_hotel_cruser'] = 2;

$conf['actionStatusList'] = "NEW,DELETE,UPDATE-all,UPDATE-all-vhost,UPDATE-all-baseurlconf,UPDATE-all-adminusers,UPDATE-all-devhotels,UPDATE-adminusers,UPDATE-vhost,UPDATE-devhotels,UPDATE-baseurlconf,CREATETAG";