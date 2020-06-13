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
	
	public function regist() {
		$this->hookRegist(array(
			'user.view.options.after' => 'xProberPlugin.addMenu',
		));
	}

	public function addMenu($options) {
		$config = $this->getConfig();
		$menu = array(
			'name'		=> 'xProber',
			'icon'		=> $this->appIcon(),
			'url'		=> $this->pluginApi,
			'target'	=> '_blank',//_blank=新页面; 空/self=当前页面;inline=当前页面frame;
			'subMenu'	=> $config['menuSubMenu'],
			'use'		=> '1'
		);
		return ActionCall('admin.setting.addMenu', $options, $menu);
	}
	
	public function index() {
		header('Location: '.$this->pluginHost . 'xProber/');
	}
}
 
// class xProberPlugin extends PluginBase {
//     function __construct() {
//         parent::__construct();
//     }
    
//     public function regiest() {
//         $this->hookRegiest(array(
//             'templateCommonHeader' => 'xProberPlugin.addMenu'
//         ));
//     }
    
//     public function addMenu() {
//         $config = $this->getConfig();
//         $subMenu = $config['menuSubMenu'];
        
//         navbar_menu_add(array(
//             'name'      => LNG('xProber.meta.name'),
//             'icon'      => $this->appIcon(),
//             'url'       => 'javascript:(core.openWindow("' . $this->pluginApi . '", "' . LNG('xProber.meta.name') . '"))',
//             'target'    => '',
//             'subMenu'   => $subMenu,
//             'use'       => '1'
//         ));
//     }
    
//     public function index() {
//         header('Location: ' . $this->pluginHost . 'xProber/');
//     }
// }