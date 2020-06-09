<?php
/**
 * PSD 看图插件
 * 
 * @author mengkun(https://mkblog.cn)
 * 
 * 本插件基于以下开源项目：
 * - PSD.js                 https://github.com/meltingice/psd.js
 * - jQuery json-viewer     https://github.com/abodelot/jquery.json-viewer
 */
class psdViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    
    public function regist() {
        $this->hookRegist(array(
            'user.commonJs.insert' => 'psdViewerPlugin.echoJs'
        ));
    }
    
    public function echoJs() {
        $this->echoFile('static/main.js');
    }
}