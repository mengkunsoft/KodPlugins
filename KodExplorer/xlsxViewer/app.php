<?php
/**
 * .xlsx 前端预览插件
 * 
 * @author mengkun(https://mkblog.cn)
 * 
 * 本插件基于以下开源项目：
 * - SheetJS    https://github.com/SheetJS/sheetjs
 * - jExcel     https://github.com/paulhodel/jexcel
 * 
 * 图标作者：
 * - blackvariant     https://www.easyicon.net/1185986-Excel_icon.html
 */

class xlsxViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'xlsxViewerPlugin.echoJs'
        ));
    }
    
    public function echoJs($st, $act) {
        if ($this->isFileExtence($st, $act)) {
            $this->echoFile('static/main.js');
        }
    }
    
    public function index() {
        $path = _DIR($this->in['path']);
        $fileUrl  = _make_file_proxy($path);
        $fileName = get_path_this(rawurldecode($this->in['path']));
        $fileName = htmlspecialchars($fileName);
        include($this->pluginPath . 'static/page.html');
    }
}