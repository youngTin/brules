<?php
class DbConnection
{
  public static function get()
  {
    static $db = null;
    if ( $db == null )
      $db = new DbConnection();
    return $db;
  }
 
  private $_handle = null;
 
  private function __construct()
  {
    $this->_handle =new MysqlPdo();
  }
  
  public function handle()
  {
    return $this->_handle;
  }
}
 
print_r( DbConnection::get()->handle());exit;
?>