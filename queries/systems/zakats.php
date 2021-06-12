<?php 

class Zakats extends Paths {
 
    public function reqZakat($idbiodatapemberi, $zakatype, $zakatmount){
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

    public function listZakatReq(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='belum'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    public function listZakatPending(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='pending'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    public function listZakatProses(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='proses'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    public function listZakatLunas(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='lunas'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    public function getDataReq($id_zakatReq){
        $sql = "SELECT * FROM zakat_req WHERE id_zakatReq=?";
        
        if($stmt = $this->prepare($sql)):
            $stmt->bind_param('i', $param_idzakatreq);
            $param_idzakatreq = $id_zakatReq;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->data_idzakatreq,
                    $this->data_idbiodatapemberi,
                    $this->data_zakattype,
                    $this->data_zakatamount,
                    $this->data_statuslunas
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
    

    public function changeStatus($statuszakat ,$id_zakatReq){
        $sql = "UPDATE zakat_req SET status_lunas=? WHERE id_zakatReq=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("si", $param_statzakat, $param_idzakatreq);
            $param_statzakat = $statuszakat;
            $param_idzakatreq = $id_zakatReq;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();

    }

    public function belumToPending($idzakatreq, $idpj, $idpenerima){
        $sql = "INSERT INTO zakat_history(id_zakatReq, id_pj, id_penerima) VALUES (?, ?, ?)";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("iii", $param_zakareqid, $param_pjid, $param_penerimaid);
            $param_zakareqid = $idzakatreq;
            $param_pjid = $idpj;
            $param_penerimaid = $idpenerima;
            
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;
    }
    
    public function pendingProses($buktiPemb, $tglPemb, $tahunHij, $idZakatHist){
        $sql = "UPDATE zakat_history SET bukti_pembayaran=?, tanggal_pembayaran=?, tahun_hijri=? WHERE id_zakatHist=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("ssii", $param_buktipemb, $param_tglpemb, $param_tahunhij, $param_zakathistid);
            $param_buktipemb = $buktiPemb;
            $param_tglpemb = $tglPemb;
            $param_tahunhij = $tahunHij;
            $param_zakathistid = $idZakatHist;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;
    }

    public function pendingToLunas($buktiPemb, $tglPemb, $idZakatHist){
        $sql = "UPDATE zakat_history SET bukti_pemberian=?, tanggal_pemberian=? WHERE id_zakatHist=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("ssi", $param_buktipemb, $param_tglpemb, $param_zakathistid);
            $param_buktipemb = $buktiPemb;
            $param_tglpemb = $tglPemb;
            $param_zakathistid = $idZakatHist;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;
    }
}

?>