<?php 

class PenerimaQuerys extends Paths {

    // menambahkan data penerima, untuk nanti zakatnya diserahkan
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

    // memperlihatkan semua data penerima yang akan mendapatkan zakat nya
    public function listDataPenerima(){
        $sql = "SELECT id_penerima, nama, reason, alamat_lengkap, kode_pos, foto_penerima, foto_tempatTinggal FROM biodata_penerima";
        $stmt = $this->query($sql);

        return $stmt;
    }

    // mencari penerima yang terdekat dengan pj
    public function penerimaTerdekatPJ($kodepospj){
        $sql = "SELECT id_penerima, nama FROM biodata_penerima WHERE kode_pos = ". $kodepospj;
        $stmt = $this->query($sql);

        return $stmt;
    }

    // menperlihatkan detail biodata penerima
    public function getDataPenerima($id_penerima){
        $sql = "SELECT * FROM biodata_penerima WHERE id_penerima=?";
        
        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_idpenerima);
            $param_idpenerima = $id_penerima;
            if ($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->id_penerima,
                    $this->nama,
                    $this->reason,
                    $this->alamat_lengkap,
                    $this->kode_pos,
                    $this->foto_penerima,
                    $this->foto_tempatTinggal
                );
                $stmt->fetch();
                if($stmt->num_rows == 1):
                    return true;
                else:
                    return false;
                endif;
            endif;
        endif;

        $stmt->close();
    }

    // edit data detail dari penerima
    public function editDataPenerima($nama, $reason, $alamat, $kodepos, $fotopenerima, $fototempat, $id_penerima){
        $sql = "UPDATE biodata_penerima SET nama=?, reason=?, alamat_lengkap=?, kode_pos=?, foto_penerima=?, foto_tempatTinggal=? WHERE id_penerima=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("sssissi", $param_nama, $param_reason, $param_alamat, $param_kodepos, $param_penerima, $param_fototempat, $param_idpenerima);
            $param_nama = $nama;
            $param_reason = $reason;
            $param_alamat = $alamat;
            $param_kodepos = $kodepos;
            $param_penerima = $fotopenerima;
            $param_fototempat = $fototempat;
            $param_idpenerima = $id_penerima;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();

    }

    // Hapus data penerima yang ada pada database
    public function deleteDataPenerima($id_penerima){
        $sql = "DELETE FROM biodata_penerima WHERE id_penerima=?";
        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_idpenerima);
            $param_idpenerima = $id_penerima;
            if ($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();
    }

}

?>