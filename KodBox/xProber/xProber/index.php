<?php

// KOD 权限验证
include('../../../config/config.php');
Action('user.sso')->checkAuthPlugin('xProber');

// 这里给探针文件改后缀名，是防止直接被访问
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'x.php.inc');