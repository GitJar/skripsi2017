<?php
if(!defined('core')){
    exit('No Dice!');
}
class Core extends Database{

	protected $link;
	function __construct()
	{
		$this->link = parent::connect();
	}
//fungsi untuk mengecek kata dalam tabel dictionary

	function cekQuran(){
        $query = $this->link->query("SELECT idAyat, Terjemahan FROM temp_filtering");
        $result = mysqli_num_rows($query);
        return $query;
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
function BolehAwalanAkhiran($kata){

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
function HapusAkhiran1($kata){ 
	$kataAsal = $kata;
	
	if(preg_match('/([km]u|nya|[kl]ah|pun)\z/i',$kata)){ // Cek Inflection Suffixes
		$__kata = preg_replace('/([km]u|nya|[kl]ah|pun)\z/i','',$kata);

		return $__kata;
	}
	return $kataAsal;
}

// Hapus Derivation Suffixes ("-i", "-an" atau "-kan")
function HapusAkhiran2($kata){
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
function HapusAwalan($kata){
	$kataAsal = $kata;

	/* —— Tentukan Tipe Awalan ————*/
	if(preg_match('/^(di|[ks]e)/',$kata)){ // Jika di-,ke-,se-
		$__kata = preg_replace('/^(di|[ks]e)/','',$kata);
		
		if($this->cekKamus($__kata)){
			return $__kata;
		}
		
		$__kata__ = $this->HapusAkhiran2($__kata);

		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
		
		if(preg_match('/^(diper)/',$kata)){ //diper-
			$__kata = preg_replace('/^(diper)/','',$kata);
			$__kata__ = $this->HapusAkhiran2($__kata);

			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
		}
		
		if(preg_match('/^(ke[bt]er)/',$kata)){  //keber- dan keter-
			$__kata = preg_replace('/^(ke[bt]er)/','',$kata);
			$__kata__ = HapusAkhiran2($__kata);

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
		
		$__kata__ = $this->HapusAkhiran2($__kata);
		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
	}
	
	if(preg_match('/^([mp]e)/',$kata)){
		$__kata = preg_replace('/^([mp]e)/','',$kata);
		if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
		}
		$__kata__ = $this->HapusAkhiran2($__kata);
		if($this->cekKamus($__kata__)){
			return $__kata__;
		}
		
		if(preg_match('/^(memper)/',$kata)){
			$__kata = preg_replace('/^(memper)/','',$kata);
			if($this->cekKamus($kata)){
				return $__kata;
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}

		if (preg_match('/^([m]enge)/', $kata)) {
			# code...
			$__kata = preg_replace('/^([m]enge)/','k',$kata);
			if($this->cekKamus($kata)){
				return $__kata;
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			$__kata = preg_replace('/^([m]enge)/','',$kata);
			if($this->cekKamus($kata)){
				return $__kata;
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]eng)/',$kata)){
			$__kata = preg_replace('/^([mp]eng)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]eng)/','k',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]eny)/',$kata)){
			$__kata = preg_replace('/^([mp]eny)/','s',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]e[lr])/',$kata)){
			$__kata = preg_replace('/^([mp]e[lr])/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}
		
		if(preg_match('/^([mp]en)/',$kata)){
			$__kata = preg_replace('/^([mp]en)/','t',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]en)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}

		if(preg_match('/^([mp]em)/',$kata)){
			$__kata = preg_replace('/^([mp]em)/','',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
			
			$__kata = preg_replace('/^([mp]em)/','p',$kata);
			if($this->cekKamus($__kata)){
				return $__kata; // Jika ada balik
			}
			
			$__kata__ = $this->HapusAkhiran2($__kata);
			if($this->cekKamus($__kata__)){
				return $__kata__;
			}
		}	
	}
	return $kataAsal;
}

//fungsi pencarian akar kata
function stemming($kata){ 

	$kataAsal = $kata;

	$cekKata = $this->cekKamus($kata);
	if($cekKata == true){ // Cek Kamus
		return $kata; // Jika Ada maka kata tersebut adalah kata dasar
	}else{ //jika tidak ada dalam kamus maka dilakukan stemming
		$kata = $this->HapusAkhiran1($kata);
		if($this->cekKamus($kata)){
			return $kata;
		}
		
		$kata = $this->HapusAkhiran2($kata);
		if($this->cekKamus($kata)){
			return $kata;
		}
		
		$kata = $this->HapusAwalan($kata);
		if($this->cekKamus($kata)){
			return $kata;
		}
	}
}
}
?>