<?php
/**
 * .docx 前端预览插件
 * 
 * @author mengkun(https://mkblog.cn)
 * 
 * 本插件基于以下开源项目：
 * - mammoth.js     https://github.com/mwilliamson/mammoth.js
 * - Typo.css       https://github.com/sofish/Typo.css
 * 
 * 图标作者：
 * - Eve巧凤
 */

class docxViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'docxViewerPlugin.echoJs'
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