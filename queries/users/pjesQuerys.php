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

    public function listPJNotActive(){
        $sql = "SELECT id_pj, id_biodata, status_active, phone_no, debit_card, no_rek FROM biodata_pj WHERE status_active=0";
        $stmt = $this->query($sql);

        return $stmt;
    }

    public function getDetailPJ($id_pj){
        $sql = "SELECT * FROM biodata_pj WHERE id_pj=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_pjid);
            $param_pjid = $id_pj;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->getIDpj,
                    $this->getIDbiodata,
                    $this->getStatusActive,
                    $this->getKtpFoto,
                    $this->getKtpAndUser,
                    $this->getPhoneNo,
                    $this->getDebitCard,
                    $this->getNoRek
                );
                $stmt->fetch();
                if($stmt->num_rows == 1):
                    return true;
                else:
                    return false;
                endif;
            endif;
        endif;
    }

    public function getIDpj($id_biodata){
        $sql = "SELECT id_pj FROM biodata_pj WHERE id_biodata=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_biodataid);
            $param_biodataid = $id_biodata;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->getIDpj
                );
                $stmt->fetch();
                if($stmt->num_rows == 1):
                    return true;
                else:
                    return false;
                endif;
            endif;
        endif;
    }

    public function tolakPj($id_pj){
        $sql = "DELETE FROM biodata_pj WHERE id_pj=?";
        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_idpj);
            $param_idpj = $id_pj;
            if ($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();
    }

    public function terimaPj($idpj){
        $sql = "UPDATE biodata_pj SET status_active=? WHERE id_pj=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("ii", $param_status, $param_idpj);
            $param_status = "1";
            $param_idpj = $idpj;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();

    }




}

?> 