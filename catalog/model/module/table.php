<?php  
class ModelModuleTable extends Model{
	public function searchGood($kod_zakaza)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_excel` WHERE `kod_zakaza` = '" . (int)$kod_zakaza . "'");

		$products = array();
		 
		// Check if there are any rows returned from the query
		if ($query->num_rows > 0) {
			// Loop through the returned rows for processing
			foreach ($query->rows as $result) {
				$r = $result['cena'];
			}
		}
		 
		return $r;
		
	}
}
?>