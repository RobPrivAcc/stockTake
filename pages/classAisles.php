<?php
class aislesOptions
{
    // property declaration
    private $swordsArray = array('---','1A','1B','1C','1D','1E','1F','1G','1H','1I','1J','2A','3','4','5','6A','6B','7A','7B','7C','8','9A','9B','9C','10A','10B','10C','11A','11B','11C','12A','12B','12C','13A','13B','13C','14A','14B','14C','14D','14E','14F','14G','14H','14I','14J','15','16','17','18','19','F','Tag Box');
    private $petcoArray = array('---','1A','1B','1C','1D','1E','1F','1G','1H','1I','1J','1K','1L','1M','1N','1O','2A','2B','3A','3B','4A','4B','4C','4D','4E','5A','5B','5C','5D','6A','6B','7','8A','8B','8C','8D','8E','8F','8G','8H','8I','8J','8K','8L','8M','8N','8O','9A','9B','9C','10A','10B','11','12','13','14','15','FLOOR','F1A','F1B','F2A','F2B','F2C','F2D','F2E','F2F','F2G','F2H','F3A','F3B','F4','F9','F10A','F10B','F10C','F10D','F10E','FREEZER');
    private $petzoneArray = array('---','1A','1B','1C','1D','1E','1F','1G','2A','2B','2C','2D','3A','3B','3C','3D','3E','3F','3G','3H','4A','4B','4C','4D','4E','5','6A','6B','6C','7A','7B','7C','7D','8A','8B','8C','9','10','11','12A','12B','12C','13A','13B','13C','14','15','16');
    private $donaghmedeArray = array('---','1','2A','2B','2C','2D','2E','2F','2 TOP','3A','3B','3C','4','4 TOP','5A','5B','6A','6B','6C','7A','7B','7C','7D','8A','8B','8C','8D','8 TOP','9A','9B','9C','9D','9 TOP','10A','10B','10C','10D','10 TOP','Yogies','Fridge');
    private $currentStoreArray = '';
    
    

    // method declaration
    public function getAisles($store,$id) {
        
        //$option = '<Div class="form-group">';
		$id = str_replace(" ","_",$id);
		$selId = "";
		
		if ($id == ''){
			$selId = '';
		}else{
			$selId = ' id= "'.$id.'"';
		}
            $option = '<Div class="form-group"><select '.$selId.' class="selectpicker form-control">';
            
                if($store == 'swords'){
                    $this->currentStoreArray = $this->swordsArray;
                }

                if($store == 'local_XPS'){
                    $this->currentStoreArray = $this->petcoArray;
                }
				
				
				if($store == 'donaghmede'){
                    $this->currentStoreArray = $this->donaghmedeArray;
                }
                
                if($store == 'petco'){
                    $this->currentStoreArray = $this->petcoArray;
                }
                
                if($store == 'petzone'){
                    $this->currentStoreArray = $this->petzoneArray;
                }
                
                $arrayLength = count($this->currentStoreArray);
                for($i=0; $i < $arrayLength; $i++){
                    $option .= '<option>'.$this->currentStoreArray[$i].'</option>';
                }
            
            $option .= '</select></div>';
        
        return $option;

    }
	public function getTest($store,$id) {
		$new = $store." - ".$id;
		return $new;
		
	}
}
?>
