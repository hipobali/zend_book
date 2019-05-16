<?php
class Application_Model_Abstract
{
    public static function getDb()
    {
        static $db = null;
        if (null===$db) {
            $dbconfig = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
            $db = Zend_Db::factory($dbconfig->resources->db);
            $db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $db->query("set names 'utf8'");
        }
        return $db;
    }

    public static function getZendCache($lifetime=null)
    {
        $frontendOption = array('lifetime' => $lifetime, 'automatic_serialization' => true);
        $backendOption = array('cache_dir'=>APPLICATION_PATH.'/../data/cache');
        $cache = Zend_Cache::factory('Core', 'File', $frontendOption, $backendOption);
        $cache->clean(Zend_Cache::CLEANING_MODE_OLD);
        return $cache;
    }    

}