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

    /*function cekQuran(){
        $query = $this->link->query("SELECT idAyat, Terjemahan FROM albaqarah where idAyat !=31 and idAyat!=61 and idAyat!=109 and idAyat!=114 and idAyat!=120 and idAyat!=148 and idAyat!=164 and idAyat!=197 and idAyat!=207 and idAyat!=215 and idAyat!=217 and idAyat!=247 and idAyat!=257 and idAyat!=264 and idAyat!=268 and idAyat!=270 and idAyat!=273 and idAyat!=282");
        $result = mysqli_num_rows($query);
        return $query;
    }*/
    function cekQuran(){
        $query = $this->link->query("SELECT idAyat, Terjemahan FROM temp_filtering where idAyat !=109 and idAyat!=148 and idAyat!=164 and idAyat!=207 and idAyat!=217 and idAyat!=247 and idAyat!=264 and idAyat!=282");
        $result = mysqli_num_rows($query);
        return $query;
    }
/*    function cekQuran(){
        $query = $this->link->query("SELECT idAyat, Terjemahan FROM temp_filtering where idAyat=30");
        $result = mysqli_num_rows($query);
        return $query;
    }*/
    function insertFiltering($d,$t){
        $query = $this->link->query("INSERT INTO temp_filtering  VALUES ('$d','$t')");
    }
    function insertStemming($d,$t){
        $query = $this->link->query("INSERT INTO temp_stemming  VALUES ('$d','$t')");
    }
    function cariStopword($kata){
        //var_dump($kata);
        $sql = $this->link->query("SELECT stopword FROM stopword WHERE stopword='$kata'");
        $result = mysqli_fetch_assoc($sql);
        return $result["stopword"];
    }
    function cekKamus($kata){ 
        $result = $this->link->query("SELECT * from katadasar where katadasar ='$kata' LIMIT 1");
    //$result = mysql_num_rows($sql);

        if($result->num_rows == 1){
        return true; // True jika ada
    }else{
        return false; // jika tidak ada FALSE
    }
}

// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
function antiAwalAkhir($kata){

    if(preg_match('/^(be)[[:alpha:]]+/(i)\z/i',$kata)){ // be- dan -i
        return true;
    }

    if(preg_match('/^(se)[[:alpha:]]+/(i|kan)\z/i',$kata)){ // se- dan -i,-kan
        return true;
    }
    
    if(preg_match('/^(di)[[:alpha:]]+/(an)\z/i',$kata)){ // di- dan -an
        return true;
    }
    
    if(preg_match('/^(me)[[:alpha:]]+/(an)\z/i',$kata)){ // me- dan -an
        return true;
    }
    
    if(preg_match('/^(ke)[[:alpha:]]+/(i|kan)\z/i',$kata)){ // ke- dan -i,-kan
        return true;
    }
    return false;
}

//fungsi untuk menghapus suffix seperti -ku, -mu, -kah, dsb
function hapusAkhiran1($kata){ 
    $kataAsal = $kata;
    
    if(preg_match('/([km]u|nya|[kl]ah|pun)\z/i',$kata)){ // Cek Inflection Suffixes
        $__kata = preg_replace('/([km]u|nya|[kl]ah|pun)\z/i','',$kata);

        return $__kata;
    }
    return $kataAsal;
}

// Hapus Derivation Suffixes ("-i", "-an" atau "-kan")
function hapusAkhiran2($kata){
    $kataAsal = $kata;
    if(preg_match('/(i|an)\z/i',$kata)){ // Cek Suffixes
        $__kata = preg_replace('/(i|an)\z/i','',$kata);
        if($this->cekKamus($__kata)){ // Cek Kamus
            return $__kata;
        }else if(preg_match('/(kan)\z/i',$kata)){
            $__kata = preg_replace('/(kan)\z/i','',$kata);
            if($this->cekKamus($__kata)){
                return $__kata;
            }
        }
        /*– Jika Tidak ditemukan di kamus –*/
    }
    return $kataAsal;
}

// Hapus Derivation Prefix ("di-", "ke-", "se-", "te-", "be-", "me-", atau "pe-")
function hapusAwalan($kata){
    $kataAsal = $kata;

    /* —— Tentukan Tipe Awalan ————*/
    if(preg_match('/^(di|[ks]e)/',$kata)){ // Jika di-,ke-,se-
        $__kata = preg_replace('/^(di|[ks]e)/','',$kata);
        
        if($this->cekKamus($__kata)){
            return $__kata;
        }
        
        $__kata__ = $this->hapusAkhiran2($__kata);

        if($this->cekKamus($__kata__)){
            return $__kata__;
        }
        
        if(preg_match('/^(diper)/',$kata)){ //diper-
            $__kata = preg_replace('/^(diper)/','',$kata);
            $__kata__ = $this->hapusAkhiran2($__kata);

            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            
        }
        
        if(preg_match('/^(ke[bt]er)/',$kata)){  //keber- dan keter-
            $__kata = preg_replace('/^(ke[bt]er)/','',$kata);
            $__kata__ = hapusAkhiran2($__kata);

            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }

    }
    
    if(preg_match('/^([bt]e)/',$kata)){ //Jika awalannya adalah "te-","ter-", "be-","ber-"

    $__kata = preg_replace('/^([bt]e)/','',$kata);
    if($this->cekKamus($__kata)){
            return $__kata; // Jika ada balik
        }
        
        $__kata = preg_replace('/^([bt]e[lr])/','',$kata);  
        if($this->cekKamus($__kata)){
            return $__kata; // Jika ada balik
        }   
        
        $__kata__ = $this->hapusAkhiran2($__kata);
        if($this->cekKamus($__kata__)){
            return $__kata__;
        }
    }
    
    if(preg_match('/^([mp]e)/',$kata)){
        $__kata = preg_replace('/^([mp]e)/','',$kata);
        if($this->cekKamus($__kata)){
            return $__kata; // Jika ada balik
        }
        $__kata__ = $this->hapusAkhiran2($__kata);
        if($this->cekKamus($__kata__)){
            return $__kata__;
        }
        
        if(preg_match('/^(memper)/',$kata)){
            $__kata = preg_replace('/^(memper)/','',$kata);
            if($this->cekKamus($kata)){
                return $__kata;
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }

        if (preg_match('/^([mp]enge)/', $kata)) {
            # code...
            $__kata = preg_replace('/^([mp]enge)/','',$kata);
            if($this->cekKamus($kata)){
               return $__kata;
           }
           $__kata__ = $this->hapusAkhiran2($__kata);
           if($this->cekKamus($__kata__)){
               return $__kata__;
           }
           $__kata = preg_replace('/^([mp]enge)/','k',$kata);
           if($this->cekKamus($kata)){
            return $__kata;
        }
        $__kata__ = $this->hapusAkhiran2($__kata);
        if($this->cekKamus($__kata__)){
            return $__kata__;
        }
    }
    
    if(preg_match('/^([mp]eng)/',$kata)){
        $__kata = preg_replace('/^([mp]eng)/','',$kata);
        if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            
            $__kata = preg_replace('/^([mp]eng)/','k',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }

        
        if(preg_match('/^([mp]eny)/',$kata)){
            $__kata = preg_replace('/^([mp]eny)/','s',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        
        if(preg_match('/^([mp]e[lr])/',$kata)){
            $__kata = preg_replace('/^([mp]e[lr])/','',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        
        if(preg_match('/^([mp]en)/',$kata)){
            $__kata = preg_replace('/^([mp]en)/','t',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            
            $__kata = preg_replace('/^([mp]en)/','',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }

        if(preg_match('/^([mp]em)/',$kata)){
            $__kata = preg_replace('/^([mp]em)/','',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            
            $__kata = preg_replace('/^([mp]em)/','p',$kata);
            if($this->cekKamus($__kata)){
                return $__kata; // Jika ada balik
            }
            
            $__kata__ = $this->hapusAkhiran2($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }   
    }
    return $kataAsal;
}

//fungsi pencarian akar kata
function stemming($kalimat){ 
    $array = explode(" ",$kalimat);
    foreach($array as $kata){
        $cekKata = $this->cekKamus($kata);
    if($cekKata == true){ // Cek Kamus
        $hasil[] = $kata; // Jika Ada maka kata tersebut adalah kata dasar
    }else{ //jika tidak ada dalam kamus maka dilakukan stemming
        $kata = $this->hapusAkhiran1($kata);
        if($this->cekKamus($kata)){
            $hasil[] = $kata;
        }
        else {
            $kata = $this->hapusAkhiran2($kata);
            if($this->cekKamus($kata)){
                $hasil[] = $kata;
            }
            else {
                $kata = $this->hapusAwalan($kata);
                if($this->cekKamus($kata)){
                    $hasil[] = $kata;
                }
            }
        }
    }
}
return implode(' ', $hasil);
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
