<?php 

    class pjesQuerys extends Databases {

        public $ktp_path = "../../";
        public $ktp_andUser = ;

        public function requestPJ($id_biodata, $status, $ktp, $ktpuser, $card, $no_rek){
            $sql = "INSERT INTO biodata_pj (id_biodata, status_active, ktp_foto, ktp_and_users, debit_card, no_rek)";

            if($stmt = $this->prepare($sql)){
                $stmt = bind_param('iissss', $param_idbio, $param_status, $param_ktpoto, $param_ktpuser, $param_card, $param_norek);
                $param_idbio = $id_biodata;
                $param_status = $status;
                $param_ktpoto = $ktp;
                $param_ktpuser = $ktpuser;
                $param_card = $card;
                $param_norek = $no_rek;

                if($stmt->execute()){
                    move_uploaded_file();
                    return true;
                    
                }else {
                    return false;
                }
            }
            $stmt->close();
        }

        

    }

?> 