<?php 

class fitrahQuerys extends Paths {
 
    public function reqFitrah(){
        $sql = "INSERT INTO zakat_req (id_biodataPemberi, id_penerima, zakat_type, zakat_amount) VALUE (?, ?, ?, ?)";


    }

}

?>