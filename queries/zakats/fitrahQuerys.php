<?php 

class FitrahQuerys extends Paths {
 
    public function reqFitrah($idbiodatapemberi, $zakatype, $zakatmount){
        $sql = "INSERT INTO zakat_req (id_biodataPemberi, zakat_type, zakat_amount, status_lunas) VALUE (?, ?, ?, ?)";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("isss", $param_idbiodatapemberi, $param_zakatype, $param_zakatmount, $param_lunas);
            $param_idbiodatapemberi = $idbiodatapemberi;
            $param_zakatype = $zakatype;
            $param_zakatmount = $zakatmount;
            $param_lunas = "belum";
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;
    }

    public function listFitrahReq(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='belum'";
        $stmt = $this->query($sql);

        return $stmt;
    }


}

?>