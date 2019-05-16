<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * 
     * application/configs/routes.ini
     */    

    protected function _initRouteSetup()
    {   
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');
        $router->addConfig($config, 'routes');
        $router->addDefaultRoutes();
    }

    /**
     * Plug-in settings
     */
    protected function _initPlugin()
    {
        $this->bootstrap("FrontController");
        $front = $this->getResource("FrontController");
        $front->registerPlugin(new CommonPlugin()); // ここで共通処理プラグイン登録
    }
    
    /**
     * Settings for logging
     * Use mainly when ErrorController is called
     *
     * @return Zend_Log
     */
    protected function _initLog()
    {
        $resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        $request= new Zend_Controller_Request_Http();
        $mapping = array(
            'level'          =>'priority',
            'priority'       =>'priorityName',
            'msg'            => 'message',
            'ua'             => 'ua',
            'ip'             => 'ip',
            'request_uri'    => 'request_uri',
            'request_method' => 'request_method',
            'params'         => 'params',
            'cr_date'        => 'timestamp',
            );
        $writer = new Zend_Log_Writer_Db($db, 'zend_logs', $mapping);
        $log = Zend_Log::factory(array('timestampFormat'=>'Y-m-d H:i:s', $writer));
        $log->setEventItem('ua', $request->getServer('HTTP_USER_AGENT'));
        $log->setEventItem('ip', $request->getClientIp());
        $log->setEventItem('request_uri', $request->getServer('REQUEST_URI'));
        $log->setEventItem('request_method', $request->getMethod());
        $log->setEventItem('params', serialize($request->getParams()));
        
        return $log;
    }
}

/**
 * Common processing plug-ins
 */
class CommonPlugin extends Zend_Controller_Plugin_Abstract
{
    /**
     * Events that occur when the router to start processing
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {

    }

    /**
     * Event that occurs when the router has finished processing
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {

    }

    /**
     * Events that occur when you start the disk loop
     * ・Do the login check
     * ・In the login page, redirect if already login to TOP
     * ・In addition to the login page, if not logged in, redirect to the login page
     */

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        // echo "hello world";
    }

    /**
     * Events that occur prior to dispatch
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

    }

    /**
     * Events that occur after it has been dispatched
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {


    }

    /**
     * Events that occurs when you exit the dispatch loop
     */
    public function dispatchLoopShutdown()
    {

    }
}