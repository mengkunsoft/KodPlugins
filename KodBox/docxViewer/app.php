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
	
	public function regist() {
		$this->hookRegist(array(
			'user.commonJs.insert' => 'docxViewerPlugin.echoJs',
		));
	}
	
	public function echoJs() {
		$this->echoFile('static/main.js');
	}
	
	public function index() {
		$fileUrl  = $this->filePathLink($this->in['path']) . '&name=/' . $this->in['name'];
		$fileName = $this->in['name'];
		include($this->pluginPath . 'static/page.html');
	}
}
