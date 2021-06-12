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

    public function getDetailBiodata($id_biodata){
        $sql = "SELECT * FROM biodata WHERE id_biodata=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_idbiodata);
            $param_idbiodata = $id_biodata;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->get_idbiodata,
                    $this->get_nama,
                    $this->get_emails,
                    $this->get_pass,
                    $this->get_kode_pos,
                    $this->get_rt,
                    $this->get_rw,
                    $this->get_nomorrumah,
                    $this->get_alamatlengkap
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