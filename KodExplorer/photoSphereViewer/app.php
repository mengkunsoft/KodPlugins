<?php

class photoSphereViewerPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'photoSphereViewerPlugin.echoJs'
        ));
    }
    
    public function echoJs($st,$act) {
        if ($this->isFileExtence($st,$act)) {
            $this->echoFile('static/main.js');
        }
    }
    
    public function index() {
        $path = _DIR($this->in['path']);
        $fileUrl = _make_file_proxy($path);
        $fileName = get_path_this(rawurldecode($this->in['path']));
        include($this->pluginPath.'static/page.html');
    }
}