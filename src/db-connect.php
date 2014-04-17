<?php 
  define('DB_NAME', getenv('RDS_DB_NAME'));
  define('DB_USER', getenv('RDS_USERNAME'));
  define('DB_PASSWORD', getenv('RDS_PASSWORD'));
  define('DB_HOST', getenv('RDS_HOSTNAME'));
  define('DB_TABLE', 'urler');
?>