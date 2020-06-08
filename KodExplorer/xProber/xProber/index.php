<?php
include('./../../../app/api/sso.class.php');
SSO::sessionAuth('xProberAccess', 'check=roleID&value=1');

// 这里给探针文件改后缀名，是防止直接被访问
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'x.php.inc');