<?php 

class PjesQuerys extends Paths {

    public function requestPJ($id_biodata, $status, $ktp, $ktpuser, $phone, $card, $no_rek){
        $sql = "INSERT INTO biodata_pj (id_biodata, status_active, ktp_foto, ktp_and_user, phone_no, debit_card, no_rek) VALUE (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("iisssss", $param_idbio, $param_status, $param_ktpoto, $param_ktpuser, $param_phone, $param_card, $param_norek);
            $param_idbio = $id_biodata;
            $param_status = $status;
            $param_ktpoto = $ktp;
            $param_ktpuser = $ktpuser;
            $param_phone = $phone;
            $param_card = $card;
            $param_norek = $no_rek;

            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;
            
        $stmt->close();
    }

    public function listPJActive(){
        $sql = "SELECT id_pj, id_biodata, status_active, phone_no, debit_card, no_rek FROM biodata_pj WHERE status_active=1";
        $stmt = $this->query($sql);

        return $stmt;
    }
}

?> 