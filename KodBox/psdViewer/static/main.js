kodReady.push(function() {
	if(!$.supportCanvas()) return;
	
	// 事件响应
    var menuAction = function(arg, action) {
        Tips.loading();
        try {
            var fileUrl = core.path2url(arg[0]);
            var fileName = (arg[2]).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            requireAsync("{{pluginHost}}static/psd.min", function(plugin) {
                var PSD = requirePSD("psd");
                PSD.fromURL(fileUrl).then(function(psd) {
                    Tips.close();
                    switch (action) {
                        case "view-psd-layer":
                            var data = psd.tree().export();
                            if ($.artDialog) {
                                requireAsync([
                                        "{{pluginHost}}static/json-viewer/jquery.json-viewer.js",
                                        "{{pluginHost}}static/json-viewer/jquery.json-viewer.css"
                                ], function() {
                                    var dialog = $.artDialog({
                                        title: fileName + " - {{LNG['psdViewer.dialog.viewPsdLayer.title']}}",
                                        content: "<div id='psd-layer-info' style='max-height: 500px; overflow: auto;margin: 10px; min-width: 500px;line-height: 22px;'></div>",
                                        ok: true
                                    });
                                    $("#psd-layer-info").jsonViewer(data);
                                    dialog.position('50%', '50%');
                                });
                            } else {
                                alert(JSON.stringify(data), undefined, 2);
                            }
                            break;
                        
                        case "download-as-png":
                            download(psd.image.toBase64(), fileName + ".png");
                            break;
                        
                        default:
                            $("body").append('<div class="view-img"><style>.view-img{box-sizing: border-box;position:fixed;background:#000;background:rgba(0,0,0,.7);width:100%;height:100%;top:0;left:0;text-align:center;padding:2%;z-index:999;cursor: zoom-out}.view-img img{max-width:100%;max-height:100%;position:relative;top:50%;transform: translateY(-50%);}</style><img src="' + psd.image.toBase64() + '" alt="' + fileName + '" title="' + fileName + '"></div>');
                            
                            $(".view-img").off().on('click', function () {
                                $(this).fadeOut(200);
                            });
                    }
                });
            });
        } catch (e) {
            Tips.close("Error");
            // Tips.notify.tips("Error", "error", 6000);
        }
    };
    
    // 右键扩展菜单响应
    function expandMenuAction(action) {
        var param = kodApp.pathAction.makeParamItem(),
          path = param.path,
          name = param.name,
          ext = pathTools.pathExt(name),
          args = new Array(path, ext, name);
        menuAction(args, action);
    }
    
    // 右键菜单配置
    var contextMenuOptions = {
            "psdViewerTool": {
                name: "{{LNG['psdViewer.contextMenu.psdTool']}}",
                className: "psdViewerTool",
                icon: "{{pluginHost}}static/images/icon.png",
                items: {
                    "view-psd": {
                        name: "{{LNG['psdViewer.contextMenu.viewPsd']}}",
                        className: "view-psd",
                        icon: "{{pluginHost}}static/images/icon.png",
                        callback: expandMenuAction
                    },
                    "view-psd-layer": {
                        name: "{{LNG['psdViewer.contextMenu.viewPsdLayer']}}",
                        className: "view-psd-layer",
                        icon: "icon-external-link",
                        callback: expandMenuAction
                    },
                    "download-as-png": {
                        name: "{{LNG['psdViewer.contextMenu.downloadAsPng']}}",
                        className: "download-as-png",
                        icon: "icon-cloud-download",
                        callback: expandMenuAction
                    },
                }
            }
        };
    
    // 载入菜单
    function loadMenu(menu, menuType) {
        if(!menu.PsdViewer) {
            $.contextMenu.menuAdd(contextMenuOptions, menu, ".open-with", false);
            menu.PsdViewer = true;
        }
        
        var name = kodApp.pathAction.makeParamItem().name,
          ext = pathTools.pathExt(name),
          allowExt = $.inArray(ext, ("{{config.fileExt}}").split(","));
        
        if (allowExt == -1) {
            $.contextMenu.menuItemHide(menu, "psdViewerTool");
        } else {
            $.contextMenu.menuItemShow(menu, "psdViewerTool");
        }
    }
    
    // 挂载右键菜单
    Events.bind("rightMenu.beforeShow@.menu-path-file",       loadMenu);
    Events.bind("rightMenu.beforeShow@.menu-path-guest-file", loadMenu);
    Events.bind("rightMenu.beforeShow@.menu-simple-file",     loadMenu);
    Events.bind("rightMenu.beforeShow@.menu-tree-file",       loadMenu);
	
	// 挂载打开方式
    Events.bind('explorer.kodApp.before', function(appList) {
        appList.push({
            name: "psdView",
            icon: "{{pluginHost}}static/images/icon.png",
            title: "{{LNG['psdViewer.meta.name']}}",
            ext: "{{config.fileExt}}",
            sort: "{{config.fileSort}}",
            callback:function() {
                menuAction(arguments);
            }
        });
    });
});
