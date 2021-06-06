<?php 

class Databases {

     private $host = "localhost",
            $user = "root",
            $pass = "",
            $db = "kuliah_dzakatapp";
    
    protected $koneksi;
    
    public function __construct(){
        $this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->db);
    
        if($this->koneksi == false) die ("Can't connect to database". $this->koneksi->connect_error());    
        return $this->koneksi;
    }

    public function prepare($data)
    {
        $stmt = $this->koneksi->prepare($data);
        if(!$stmt) die ("Something Wrong when in prepare". $this->koneksi->error);
        
        return $stmt;
    }

    public function query($data) 
    {
        $stmt = $this->koneksi->query($data);
        if(!$stmt) die ("Something Wrong on Sql". $this->koneksi->error);
        
        return $stmt;
    }

    public function escape_string($value){
        return $this->koneksi->real_escape_string($value);
    }

}

?>