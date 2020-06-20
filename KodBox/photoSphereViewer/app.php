<?php
/**
 * 全景图查看插件
 * 
 * @author mengkun(https://mkblog.cn)
 * 
 * 本插件基于 Photo Sphere Viewer      
 * - https://github.com/mistic100/Photo-Sphere-Viewer
 * - https://github.com/JeremyHeleine/Photo-Sphere-Viewer
 */
class photoSphereViewerPlugin extends PluginBase {
	function __construct() {
		parent::__construct();
	}
	
	public function regist() {
		$this->hookRegist(array(
			'user.commonJs.insert' => 'photoSphereViewerPlugin.echoJs',
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
