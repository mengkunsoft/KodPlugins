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
	
	public function regist() {
		$this->hookRegist(array(
			'user.commonJs.insert' => 'xlsxViewerPlugin.echoJs',
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
