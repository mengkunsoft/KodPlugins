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
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'psdViewerPlugin.echoJs'
        ));
    }
    public function echoJs($st, $act) {
        if ($this->isFileExtence($st, $act)) {
            $this->echoFile('static/main.js');
        }
    }
}