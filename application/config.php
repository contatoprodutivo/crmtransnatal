<?php
$db_host      = getenv('DB_HOST') ?: 'localhost';
$db_user      = getenv('DB_USER') ?: 'root';
$db_password  = getenv('DB_PASSWORD') ?: '';
$db_name      = getenv('DB_NAME') ?: 'crmtransnatal';
$app_url      = getenv('APP_URL') ?: 'http://localhost/crmtransnatal';
$_app_stage   = getenv('APP_STAGE') ?: 'Dev'; // Default to Dev to enable debugging
