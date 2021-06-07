<?php 

class UserQuerys extends Databases {

    public function regUsers($nama, $emails, $pass, $kodepos, $rt, $rw, $norumah, $alamatkap){
        $sql = "INSERT INTO biodata (nama, emails, pass, kode_pos, rt, rw, nomor_rumah, alamat_lengkap) VALUE(?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $this->prepare($sql)):
            $stmt->bind_param("sssiiiis", $param_nama, $param_email, $param_pass, $param_codepos, $param_rt, $param_rw, $param_norumah, $param_alamatkap);
            $param_nama = $nama;
            $param_email = $emails;
            $param_pass = $pass;
            $param_codepos = $kodepos;
            $param_rt = $rt;
            $param_rw = $rw;
            $param_norumah = $norumah;
            $param_alamatkap = $alamatkap;

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