<?php 

class Converts extends Databases {

    public function useGold(){
        $sql = "SELECT nominal_rupiah FROM alat_tukar WHERE alatTukar='emas'";

        if($stmt = $this->prepare($sql)):
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->nominal
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

    public function useSilver(){
        $sql = "SELECT nominal_rupiah FROM alat_tukar WHERE alatTukar='perak'";

        if($stmt = $this->prepare($sql)):
            if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result(
                    $this->nominal
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