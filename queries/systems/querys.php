<?php 

class Querys extends Databases {

    public function logins($emails, $pass){
        
        $sql = "SELECT * FROM biodata WHERE emails = '$emails' AND pass = '$pass'";
        $stmt = $this->query($sql);
        
        if ($stmt->num_rows > 0) {
            $row = $stmt->fetch_array();
            return $row['id_biodata'];
        } else {
            return false;
        }        
    }

    public function sessionData($id_biodata){
        $stmt = $this->query("SELECT * FROM biodata WHERE id_biodata = '$id_biodata'");
        return $stmt->fetch_array();
    }

    public function pj_validateSession($id_biodata){
        $stmt = $this->query("SELECT COUNT(*) FROM biodata_pj WHERE id_biodata = '$id_biodata'");
        return $stmt->fetch_array()['COUNT(*)'];
        
    }

}

?>