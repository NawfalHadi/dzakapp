<?php 

class PenerimaQuerys extends Paths {
    
    public function insertDataPenerima($nama, $reason, $alamat, $kodepos, $fotopenerima, $fototempat){
        $sql = "INSERT INTO biodata_penerima(nama, reason, alamat_lengkap, kode_pos, foto_penerima, foto_tempatTinggal) VALUE (?, ?, ?, ?, ?, ?)";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("sssiss", $param_nama, $param_reason, $param_alamat, $param_kodepos, $param_penerima, $param_fototempat);
            $param_nama = $nama;
            $param_reason = $reason;
            $param_alamat = $alamat;
            $param_kodepos = $kodepos;
            $param_penerima = $fotopenerima;
            $param_fototempat = $fototempat;
            
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();
    }

    public function listDataPenerima(){
        $sql = "SELECT id_penerima,nama, reason, alamat_lengkap, kode_pos, foto_penerima, foto_tempatTinggal FROM biodata_penerima";
        $stmt = $this->query($sql);

        return $stmt;
    }

}

?>