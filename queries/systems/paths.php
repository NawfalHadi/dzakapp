<?php 

// kelas ini digunakan untuk mengambil path agar bisa dmengambil foto pada folder lain dengan lebih mudah
class Paths extends Databases {
    
    // Path menuju folder uploads/pjes
    public $ktp_path = "../../uploads/pjes/ktp/";
    public $ktpUser_path = "../../uploads/pjes/ktp_andUser/";
    
    // Path untuk bagian bukti zakat fitrah
    public $paymentFitrah_path = "../../uploads/bukti/zakatFitrah/payment/";
    public $giftFitrah_path = "../../uploads/bukti/zakatFitrah/gives/";

    // Path untuk bagian bukti zakat mal
    public $paymentMal_path = "../../uploads/bukti/zakatMal/payment/";
    public $giftMal_path = "../../uploads/bukti/zakatMal/gives/";

    // Path untuk bagian foto si penerima dan tempat tinggalnya
    public $penerima_path = "../../uploads/penerima/orang/";
    public $rumahpenerima_path = "../../uploads/penerima/tempat/";
}

?>