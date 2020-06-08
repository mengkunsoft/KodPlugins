kodReady.push(function() {
    var menuAction = function(action, option) {
        var path;
        if (action.path !== undefined) {
            path = action.path;
        } else {
            path = ui.path.makeParam().path;
        }

        if (!!path) {
            try {
                var fileUrl = core.path2url(path);
                var fileName = pathTools.pathThis(path).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                require.async("{{pluginHost}}static/psd.min", function(plugin) {
                    var PSD = requirePSD("psd");
                    PSD.fromURL(fileUrl).then(function(psd) {
                        switch (action) {
                            case "view-psd-layer":
                                var data = psd.tree().export();
                                if ($.artDialog) {
                                    require.async([
                                            "{{pluginHost}}static/json-viewer/jquery.json-viewer.js",
                                            "{{pluginHost}}static/json-viewer/jquery.json-viewer.css"
                                    ], function() {
                                        var dialog = $.artDialog({
                                            title: fileName + " - {{LNG.psdViewer.dialog.viewPsdLayer.title}}",
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
                                MaskView.image(psd.image.toBase64());
                                $("#windowMaskView").css({
                                    background: "#000"  // 部分主题打开遮罩的背景是蓝色..
                                }); 
                        }
                    });
                });
            } catch (e) {
                Tips.tips("Error", "error");
            }
        }
    };

    var option = {
        "psdViewerTool": {
            name: "{{LNG.psdViewer.contextMenu.psdTool}}",
            className: "psdViewerTool",
            icon: "{{pluginHost}}static/images/icon.png",
            items: {
                "view-psd": {
                    name: "{{LNG.psdViewer.contextMenu.viewPsd}}",
                    className: "view-psd",
                    icon: "{{pluginHost}}static/images/icon.png",
                    callback: menuAction
                },
                "view-psd-layer": {
                    name: "{{LNG.psdViewer.contextMenu.viewPsdLayer}}",
                    className: "view-psd-layer",
                    icon: "icon-external-link",
                    callback: menuAction
                },
                "download-as-png": {
                    name: "{{LNG.psdViewer.contextMenu.downloadAsPng}}",
                    className: "download-as-png",
                    icon: "icon-picture",
                    callback: menuAction
                },
            }
        }
    };

    var menuAdd = function() {
        $.contextMenu.menuAdd(option, ".menu-file", false, ".down");
        $.contextMenu.menuAdd(option, ".toolbar-path-more", false, ".others");
    };

    // 非支持的格式不显示菜单项
    Hook.bind("rightMenu.show.menu-file,rightMenu.show.menu-tree-file", function($menuAt, $theMenu) {
        var param = $(".context-menu-active").hasClass("menu-tree-file") ? ui.tree.makeParam() : ui.path.makeParam();
        var ext = core.pathExt(param.path);
        var allowExt = "{{config.fileExt}}";
        var hideClass = "hidden";

        if (inArray(allowExt.split(","), ext)) {
            $theMenu.find(".psdViewerTool").removeClass(hideClass);
        } else {
            $theMenu.find(".psdViewerTool").addClass(hideClass);
        }
    });

    menuAdd();

    kodApp.add({
        name: "psdView",
        icon: "{{pluginHost}}static/images/icon.png",
        title: "{{LNG.psdViewer.meta.name}}",
        ext: "{{config.fileExt}}",
        sort: "{{config.fileSort}}",
        callback: function(path, ext) {
            var action = {
                action: "view-psd",
                path: path
            };
            menuAction(action);
        }
    });
});