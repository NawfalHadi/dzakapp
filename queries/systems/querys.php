<?php 

class Querys extends Databases {

    // fungsi login
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

    // melihat siapa yang sedang login
    public function sessionData($id_biodata){
        $stmt = $this->query("SELECT * FROM biodata WHERE id_biodata = '$id_biodata'");
        return $stmt->fetch_array();
    }

    // melihat apakah yang sedang login adalah admin aktif
    public function pj_validateSession($id_biodata){
        $stmt = $this->query("SELECT COUNT(*) FROM biodata_pj WHERE id_biodata = '$id_biodata' AND status_active = '1'");
        return $stmt->fetch_array()['COUNT(*)'];
        
    }

    // untuk menghindari user yang sedang request menjadi PJ, agar tidak dianggap sudah menjadi admin
    public function pj_notvalidateSession($id_biodata){
        $stmt = $this->query("SELECT COUNT(*) FROM biodata_pj WHERE id_biodata = '$id_biodata' AND status_active = '0'");
        return $stmt->fetch_array()['COUNT(*)'];
        
    }

    // untuk melihat detail dari riwayat transaksi
    public function getDetailHistory($id_zakatReq){
        $sql = "SELECT * FROM zakat_history WHERE id_zakatReq=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_zakatreqid);
            $param_zakatreqid = $id_zakatReq;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->getIDzakathist,
                    $this->getIDzakatreq,
                    $this->getIDpj,
                    $this->getIDpenerima,
                    $this->bukti_pembayaran,
                    $this->bukti_pemberian,
                    $this->tanggal_pembayaran,
                    $this->tanggal_pemberian,
                    $this->tahun_hijri
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

    

}

?>