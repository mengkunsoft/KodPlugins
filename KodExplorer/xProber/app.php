<?php
/**
 * X 探针、刘海探针插件
 * 
 * @author mengkun(https://mkblog.cn)
 * 
 * 本插件基于开源项目：
 * - https://github.com/kmvan/x-prober
 */
class xProberPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    
    public function regiest() {
        $this->hookRegiest(array(
            'templateCommonHeader' => 'xProberPlugin.addMenu'
        ));
    }
    
    public function addMenu() {
        $config = $this->getConfig();
        $subMenu = $config['menuSubMenu'];
        
        navbar_menu_add(array(
            'name'      => LNG('xProber.meta.name'),
            'icon'      => $this->appIcon(),
            'url'       => 'javascript:(core.openWindow("' . $this->pluginApi . '", "' . LNG('xProber.meta.name') . '"))',
            'target'    => '',
            'subMenu'   => $subMenu,
            'use'       => '1'
        ));
    }
    
    public function index() {
        header('Location: ' . $this->pluginHost . 'xProber/');
    }
}