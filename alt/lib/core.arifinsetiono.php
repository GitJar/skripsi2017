    <?php
    if(!defined('core')){
        exit('No Dice!');
    }

    class Core extends Database
    {
        protected $link;

        public $error = '';
        public $success = '';
        function __construct()
        {
            $this->link = parent::connect();
        }

        function cekQuran(){
            $query = $this->link->query("SELECT idAyat, Terjemahan FROM albaqarah limit 2");
            $result = mysqli_num_rows($query);
            return $query;
        }
        function cariStopword($kata){
        //var_dump($kata);
            $sql = $this->link->query("SELECT stopword FROM stopword WHERE stopword='$kata'");
            $result = mysqli_fetch_assoc($sql);
            return $result["stopword"];
        }
        function cari($kata){
            $sql = $this->link->query("SELECT katadasar FROM katadasar");
            $result = mysqli_fetch_array($sql);
            return $result["katadasar"];
        }

        function cekKamus($kata,$kamus_arr){
            $hasilCari = 0;
            if($this->cari($kata)==1){
                $hasilCari = 1;
            }
            return $hasilCari;
        }
    /* ------------------------------------------------------------------
    potong kata yang berawalan me atau pe
    --------------------------------------------------------------------*/
    function potongAwalanMe($kata){
        $_2hurufAwal = substr($kata,0,2);
        $awalan = "";
        $_4hurufAwal = substr($kata,0,4);
        $_3hurufAwal = substr($kata,0,3);
        $hurufPengganti="";
        if($_4hurufAwal == "meng" || $_4hurufAwal == "peng"){
            $awalan = $_4hurufAwal;
    // hasil yang dipotong tambahkan dengan salah satu huruf berikut ini
    // hurufPengganti=['v','k','g','h','q'];
        }
        else if($_4hurufAwal == "meny" || $_4hurufAwal == "peny"){
    //awalan = _4hurufAwal.substr(0,2);
            $awalan = $_4hurufAwal;
    // ganti ny dengan huruf pengganti
    //$hurufPengganti=['s'];
        }
        else if($_3hurufAwal == "mem" || $_3hurufAwal == "pem"){
            $awalan = $_3hurufAwal;
    // tambahkan huruf pengganti jika hasil kata yang dipotong berupa huruf vokal
    //$hurufPengganti=['b','f','p','v'];
        }
        else if($_3hurufAwal == "men" || $_3hurufAwal == "pen"){
            $awalan = $_3hurufAwal;
    // tambahkan huruf pengganti jika hasil kata yang dipotong berupa huruf vokal
            $hurufPengganti=['c','d','j','s','t','z'];
        }
        else if($_3hurufAwal == "per"){
            $awalan = $_3hurufAwal;
    // hurufPengganti=['c','d','j','s','t','z'];
        }
        else if($_2hurufAwal == "me" || $_2hurufAwal == "pe"){
            $awalan = $_2hurufAwal;
    // hurufPengganti=['l','m','n','r','y','w'];
        }
        return $awalan;
    // return awalan+" "+kata.substr(awalan.length)+" "+hurufPengganti;
    }
    /* ------------------------------------------------------------------
    potong kata yang berawalan be
    --------------------------------------------------------------------*/
    function potongAwalanBe($kata){
        $awalan = "";
        $hurufPengganti="";
        $_2hurufAwal = substr($kata,0,2);
        $_3hurufAwal = substr($kata,0,3);
        if($_3hurufAwal == "ber"){
            $awalan = $_3hurufAwal;
        }
        else if($_2hurufAwal == "be" && $kata == "bekerja"){
            $awalan = $_2hurufAwal;
        }
        else if($_3hurufAwal == "bel" && $kata == "belajar"){
            $awalan = $_3hurufAwal;
        }
        return $awalan;
    // return $awalan+" "+$kata.substr($awalan.length)+" "+hurufPengganti;
    }
    /* ------------------------------------------------------------------
    potong $kata yang $awalannya selain me,pe,be
    --------------------------------------------------------------------*/
    function potongAwalanLainnya($kata){
        $awalan = "";
        $awalanLain = array("di","ke","ku","se");
    //$hurufPengganti="";
        $_2hurufAwal = substr($kata,0,2);
        $_3hurufAwal = substr($kata,0,3);
        if($_3hurufAwal == "ter"){
            $awalan = $_3hurufAwal;
    // $hurufPengganti=['r'];
        }
        else if(in_array($_2hurufAwal,$awalanLain)){
            $awalan = $_2hurufAwal;
        }
        return $awalan;
    // return $awalan+" "+$kata.substr($awalan.length)+" "+hurufPengganti;
    }
    /* ------------------------------------------------------------------
    potong $awalan
    --------------------------------------------------------------------*/
    function potongAwalan($kata){
    //jadikan huruf kecil semua
        $kata = strtolower($kata);
        $awalan1 =Array('me','di','ke','pe','se','be');
        $awalan2 =Array('ber','ter','per');
        $_2hurufAwal = substr($kata,0,2);
        $awalan[0] ="";
        $awalan[1] ="";
        for( $i =0; $i < 2; $i++){
            $awalanTmp="";
            if($_2hurufAwal == "me" || $_2hurufAwal == "pe"){
                $awalanTmp = $this->potongAwalanMe($kata);
            }
            else if($_2hurufAwal == "be"){
                $awalanTmp = $this->potongAwalanBe($kata);
            }
            else {
                $awalanTmp = $this->potongAwalanLainnya($kata);
            }
            if($awalanTmp != ""){
    //deklarasi ulang $kata dan $_2hurufAwal
                $pjgAwalan = strlen($awalanTmp);
                $kata = substr($kata,$pjgAwalan,strlen($kata) - $pjgAwalan);
                $_2hurufAwal = substr($kata,0,2);
                if(in_array($awalanTmp,$awalan2)){
    // jika $awalan[1] sudah ada isinya masukkan ke $awalan[1];
    //if($awalan[1] != ""){
    //$awalan[0] = $awalanTmp;
    // }
    //else
                    $awalan[1] = $awalanTmp;

                }
                else {
    // pengecekan dilakukan untuk menangani $kata yang ber$awalan ke seperti kerja, kemul, kemudan dll
                    if($awalan[0] == ""){
                        $awalan[0] = $awalanTmp;
                    }
                    else {
                        $awalan[1] = $awalanTmp;
                    }

                }

            }
        }
        return $awalan;
    }
    function potongAkhiran($kata){
    //jadikan huruf kecil semua
        $kata = strtolower($kata);
        $akhiran1 = array('lah','kah','pun','tah');
        $akhiran2 = array('ku','mu','nya');
        $akhiran3 = array('i','an','kan');
        $akhir = array('','','');
        $_3hurufAkhir = substr($kata,strlen($kata) - 3);
        $_2hurufAkhir = substr($kata,strlen($kata) - 2);
        $_1hurufAkhir = substr($kata,strlen($kata) - 1);
        for( $i = 0; $i < 3; $i++){
            if($i == 0){
                if( in_array($_3hurufAkhir,$akhiran1)){
                    $akhir[$i] = $_3hurufAkhir;
    //potong $kata
                    $kata = substr($kata,0,strlen($kata) - 3);
    //deklarasi ulang $akhiran
                    $_3hurufAkhir = substr($kata,strlen($kata) - 3);
                    $_2hurufAkhir = substr($kata,strlen($kata) - 2);
                    $_1hurufAkhir = substr($kata,strlen($kata) - 1);
                }
            }
            else if($i == 1){
                if( in_array($_3hurufAkhir,$akhiran2)){
                    $akhir[$i] = $_3hurufAkhir;
    //potong $kata
                    $kata = substr($kata,0,strlen($kata) - 3);
    //deklarasi ulang $akhiran
                    $_3hurufAkhir = substr($kata,strlen($kata) - 3);
                    $_2hurufAkhir = substr($kata,strlen($kata) - 2);
                    $_1hurufAkhir = substr($kata,strlen($kata) - 1);
                }
                else if( in_array($_2hurufAkhir,$akhiran2)){
                    $akhir[$i] = $_2hurufAkhir;
    //potong $kata
                    $kata = substr($kata,0,strlen($kata) - 2);
    //deklarasi ulang $akhiran
                    $_3hurufAkhir = substr($kata,strlen($kata) - 3);
                    $_2hurufAkhir = substr($kata,strlen($kata) - 2);
                    $_1hurufAkhir = substr($kata,strlen($kata) - 1);
                }
            }
            else {
                if( in_array($_3hurufAkhir,$akhiran3)){
                    $akhir[$i] = $_3hurufAkhir;
                }
                else if( in_array($_2hurufAkhir,$akhiran3)){
                    $akhir[$i] = $_2hurufAkhir;
                }
                else if( in_array($_1hurufAkhir,$akhiran3)){
                    $akhir[$i] = $_1hurufAkhir;
                }
            }
        }
        return $akhir;
    }
    function cariKataDasar($kata){
        $awalan = $this->potongAwalan($kata);
        $akhiran = $this->potongAkhiran($kata);
        $panjang2Awalan = strlen($awalan[0]) + strlen($awalan[1]);
        $panjang3Akhiran = strlen($akhiran[0]) + strlen($akhiran[1]) + strlen($akhiran[2]);
        $kataDasar = substr($kata,$panjang2Awalan,strlen($kata) - ($panjang3Akhiran +$panjang2Awalan));
        return $kataDasar;
    }
    function stemmingArifin($kata,$kamus){
        if(($this->cari($kata)==1)){
            return $kata;
        }
        else {
    /* ------------------------------------------------------------------
    hasilkan $awalan, $akhiran dan kata dasar, periksa apakah kata telah
    ditemukan. asumsinya kata selalu memiliki susunan sebagai berikut
    AW I + AW II + KD + AKH III + AKH II + AKH I
    --------------------------------------------------------------------*/
    $awalan = $this->potongAwalan($kata);
    $akhiran = $this->potongAkhiran($kata);
    $panjang2Awalan = strlen($awalan[0]) + strlen($awalan[1]);
    $panjang3Akhiran = strlen($akhiran[0]) + strlen($akhiran[1]) + strlen($akhiran[2]);
    $kataDasar = substr($kata,$panjang2Awalan,strlen($kata) - ($panjang3Akhiran +$panjang2Awalan));
    /* -----------------------------------------------------------------
    periksa apakah terjadi perubahan $kata ketika $kata dasar mendapatkan $awalan
    * pertama cek perubahan $kata jika mendapat $awalan me
    --------------------------------------------------------------------*/
    $_2hurufAwalAwalan = substr($awalan[0],0,2);
    $_2hurufAkhirAwalan = substr($awalan[0],2,2);
    $_1hurufAkhirAwalan = substr($awalan[0],2,1);
    $tempKataDasar;
    if($_2hurufAkhirAwalan == "ng"){
    // untuk $kata seperti kontak, kantuk akan dilebur menjadi mengantuk
    // tambahkan dengan huruf k
        $tempKataDasar = "k".$kataDasar;
        if($this->cekKamus($tempKataDasar,$kamus)) {
            return $tempKataDasar;
        }
    }
    if($_2hurufAkhirAwalan == "ny"){
    // tambahkan dengan huruf s
        $tempKataDasar = "s".$kataDasar;
        if($this->cekKamus($tempKataDasar,$kamus)) {
            return $tempKataDasar;
        }
    }
    if($_1hurufAkhirAwalan == "m"){
    // tambahkan dengan huruf p
        $tempKataDasar = "p".$kataDasar;
        if($this->cekKamus($tempKataDasar,$kamus)) {
            return $tempKataDasar;
        }
    }
    if($_1hurufAkhirAwalan == "n"){
    // tambahkan dengan huruf t
        $tempKataDasar = "t".$kataDasar;
        if($this->cekKamus($tempKataDasar,$kamus)) {
            return $tempKataDasar;
        }
    }
    /* -----------------------------------------------------------------
    AW II.KD.AKH III.AKH II.AKH I
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[1].$kataDasar.$akhiran[2].$akhiran[1].$akhiran[0];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    KD + AK III + AK II + AK I
    --------------------------------------------------------------------*/
    $tempKataDasar = $kataDasar.$akhiran[2].$akhiran[1].$akhiran[0];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    KD + AK III + AK II
    --------------------------------------------------------------------*/
    $tempKataDasar = $kataDasar.$akhiran[2].$akhiran[1];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    KD + AK III
    --------------------------------------------------------------------*/
    $tempKataDasar = $kataDasar.$akhiran[2];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    KD
    --------------------------------------------------------------------*/
    if($this->cekKamus($kataDasar,$kamus)) {
        return $kataDasar;
    }
    /* -----------------------------------------------------------------
    AW I.KD
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[0].$kataDasar;
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW I.AW II.KD
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[0].$awalan[1].$kataDasar;
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW I.AW II.KD.AKH III
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[0].$awalan[1].$kataDasar.$akhiran[2];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW I.AW II.KD.AKH III.AKH II
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[0].$awalan[1].$kataDasar.$akhiran[2].$akhiran[1];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW I.AW II.KD.AKH III.AKH II.AKH I
    --------------------------------------------------------------------
    $tempKataDasar = $awalan[0].$awalan[1].$kataDasar.$akhiran[2].$akhiran[1].$akhiran[0];
    if(cekKamus($tempKataDasar,$kamus)) {
    return $tempKataDasar;
    }
    * gak jadi ini = kata sebelum dilakukan pemotongan
    --------------------------------------------------------------------------*/
    /* -----------------------------------------------------------------
    AW II.KD
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[1].$kataDasar;
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW II.KD.AKH III
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[1].$kataDasar.$akhiran[2];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    }
    /* -----------------------------------------------------------------
    AW II.KD.AKH III.AKH II
    --------------------------------------------------------------------*/
    $tempKataDasar = $awalan[1].$kataDasar.$akhiran[2].$akhiran[1];
    if($this->cekKamus($tempKataDasar,$kamus)) {
        return $tempKataDasar;
    } 
}
return $kata;
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $string = str_replace('-', ' ', $string); 
    return $string;
}

function stopword($string){
    $array = explode(" ",$string);
    foreach($array as $yuk){
        if($this->cariStopword($yuk)!=$yuk){
            $hasil[] = $yuk;
        }
    }
    return implode(" ",$hasil);
}

}
?>