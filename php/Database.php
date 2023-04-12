<?php
  class Database{
    private $dbhost = '';
    private $dbuser = '';
    private $dbpw = '';
    private $dbname = '';
    private $conn = null;

    function __construct( $dbhost, $dbuser, $dbpw, $dbname ){
      $this->dbhost = $dbhost;
      $this->dbuser = $dbuser;
      $this->dbpw = $dbpw;
      $this->dbname = $dbname;
    }

    function connect(){
      try{
        $this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpw,$this->dbname);
      }
      catch( Exception $e ){
        return $e;
      }
    }

    function saveSearchAnalytics( $remoteIp, $searchTerms ){
      try{
        $sql = "INSERT INTO browser_search_analytics( remote_ip, search_terms, created_at, updated_at ) VALUES ( ?, ?, ?, ? )";
        $now = date("Y-m-d H:i:s");
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $remoteIp, $searchTerms, $now, $now );
        $stmt->execute();
      }
      catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

  }
?>
