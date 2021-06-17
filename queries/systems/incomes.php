<?php 

class Incomes extends Databases {


    // Untuk menempatkan pemasukkan agar bisa menghitung zakat mal untuk pembayaran nya
    public function addIncomes($idbiodata, $emasamount, $datepay){
        $sql = "INSERT INTO incomes_user(id_biodata, emas_amount, date_pay) VALUES (?, ?, ?)";

        if ($stmt = $this->prepare($sql)):
            $stmt->bind_param("iis", $param_idbio, $param_emasmount, $param_datepay);
            $param_idbio = $idbiodata;
            $param_emasmount = $emasamount;
            $param_datepay = $datepay;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

    }

    // untuk melihat smeua data pada incomes setiap user nya agar nanti digunakan untuk perhitungan
    public function detailIncomes($id_biodata){
        $sql = "SELECT * FROM incomes_user WHERE id_biodata=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("i", $param_idbiodata);
            $param_idbiodata = $id_biodata;
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->get_idincomes,
                    $this->get_idbiodata,
                    $this->get_emasamount,
                    $this->get_datepay
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

    // karena incomes bisa berubah rubah, agar bisa update data harta bila ada perubahan
    public function editIncomes($emasmount, $datepay, $idbiodata){
        $sql = "UPDATE incomes_user SET emas_amount=?, date_pay=? WHERE id_biodata=?";

        if($stmt = $this->prepare($sql)):
            $stmt->bind_param("isi", $param_emasmount, $param_datepay, $param_idbiodata);
            $param_emasmount = $emasmount;
            $param_datepay = $datepay;
            $param_idbiodata = $idbiodata;
            if($stmt->execute()):
                return true;
            else:
                return false;
            endif;
        endif;

        $stmt->close();
    }

    // untuk menghitung zakat mal yang harus dibayarkan yaitu 2.5% dari harta
    public function calculateZakatMal($emasamount){
        settype($emasamount, "float");
        $result = ($emasamount/100) * 2.5;
        return $result;
    }

}

?>