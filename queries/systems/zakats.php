<?php 

class Zakats extends Paths {
 
    // Untuk melakukan permintaan untuk melakukan transaksi zakat
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

    // untuk melihatkan list ke admin, ada yang sedang request atau tidak agar nanti dilanjutkan ke tahap berikutnya
    // yaitu memilih penerima yang berhak untuk dilanjutkan zakatnya
    public function listZakatReq(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='belum'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    // disini memperlihatkan list zakat, kepada user yang sudah di acc admin untuk melakukan transaksi selanjutnya
    // yaitu ke upload bukti pembayaran oleh si user
    public function listZakatPending($idbiodata, $zakattype){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='pending' AND id_biodataPemberi=".$idbiodata." AND zakat_type='$zakattype'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    // disini setelah user mengupload bukti pembayaran, admin akan melihat lagi dan diproses zakatnya menjuju ke yang berhak
    // dengan mengupload bukti pemberian kepada penerima yang berhak
    public function listZakatProses(){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='proses'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    // akan menampilkan list zakat kepada user zakat transaksi nya sudah diselesaikan oleh PJ dengan memngirimkan bukti
    // pemberian
    public function listZakatLunas($idbiodata){
        $sql = "SELECT * FROM zakat_req WHERE status_lunas='lunas' AND id_biodataPemberi=".$idbiodata;
        $stmt = $this->query($sql);

        return $stmt;
    }

    // untuk melihat list data transaksi zakat sedang direquest user ke PJ
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
    

    // agar bisa menandai zakat zakat yang sudah lunas, diproses, request, atau juga yang belum di proses
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

    // mengganti status dari belum ke pending, dan juga fungsi yang diperlukan, seperti mengirimkan id id dari
    // zakatreq, pj, dan penerima agar di taruh di list history transaksi
    public function belumToPending($idzakatreq, $idpj, $idpenerima){
        $sql = "INSERT INTO zakat_history (id_zakatReq, id_pj, id_penerima) VALUES (?, ?, ?)";

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
    
    // mengubah status dari pending ke proses, dengan mengupdate record data menaambah, bukti pembayaran, tanggal pembayran
    // dan juga tahun hijriah nya
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

    // mengubah status transaksi nya dari pending ke lunas, dan juga mengupdate bukti pemberian, dan tanggal pemberian
    // dan menjadi akhir hasil taransaksi
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

    // untuk mengambil data data zakat dengan berparameter kan idbiodata
    public function listReqByBiodata($idbiodata){
        $sql = "SELECT * FROM zakat_req WHERE id_biodataPemberi='$idbiodata' AND zakat_type='Fitrah'";
        $stmt = $this->query($sql);

        return $stmt;
    }

    
}

?>