<?php  
class ControllerModuleTable extends Controller {
	public function index() {
				
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		$this->load->language('module/table');
		$this->data['title'] = $this->language->get('title');
		if(isset($this->request->get['status'])){
			if($this->request->get['status']=='ok'){
				$this->data['send_ok'] = $this->language->get('send_ok');
			}else{
				$this->data['send_ok'] = '';
			}
		}else{
			$this->data['send_ok'] = '';
		}
		$this->data['artikul'] = $this->language->get('title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/table.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/table.tpl';
		} else {
			$this->template = 'default/template/module/table.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		
		$this->response->setOutput($this->render());
	}
	
	public function searchGood()
    {
        $this->language->load('module/table');
		 
		$json = array();
		if(isset($this->request->post['data'])){
		 
			$kod_zakaza = $this->request->post['data'];
					
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_excel` WHERE `kod_zakaza` = '" . $kod_zakaza . "'");
 
			$products = array();
			 
			// Check if there are any rows returned from the query
			if ($query->num_rows > 0) {
				// Loop through the returned rows for processing
				foreach ($query->rows as $result) {
					$products[] = array(
						'artikul' => $result['artikul'],
						'material_description' => $result['material_description'],
						'stoimost' => $result['stoimost']
					);
				}
				$json['artikul'] = 'OK';
				$json['material_description'] = $result['material_description'];
				$json['stoimost'] = $result['stoimost'];
			}else{
				$json['nothing'] = true;
			}		 
		}
		 
		$this->response->setOutput(json_encode($json));
		 
	}
	
	public function sendMail(){
		
		if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['tel'])){
			$artikuls = $_POST['artikuls'];
			$kolvo = $_POST['pieces'];
			$name=trim(strip_tags($_POST['name']));
			$email="&nbsp; ".trim(strip_tags($_POST['email']));
			$email2=trim(strip_tags($_POST['email']));
			$msg=trim(strip_tags($_POST['tel']));
			$to  = "bacs@ua.fm" ; 

			$subject = "Заказ с калькулятора"; 

			$message = "Юзер - ".$name."<br><hr>";
			$message .= "E-mail - ".$email."<br><hr>";
			$message .= "Номер телефона - ".$msg."<br><hr>";
			$message .= "Артикулы - ".$artikuls."<br><hr>"; 

			$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
			$headers .= "From: electro-kontakt.ru <admin@electro-kontakt.ru>\r\n"; 
			$headers .= "Bcc: admin@electro-kontakt.ru\r\n"; 
			mail($to, $subject, $message, $headers);
			$save = $this->saveToDB($artikuls, $name, $email2, $msg, $kolvo);
			if($save){
				$this->redirect('http://electro-kontakt.ru/index.php?route=module/table&status=ok');
			}else{
				$this->redirect('http://electro-kontakt.ru/index.php?route=module/table/error');
			}	
		}else{
			$this->redirect('http://electro-kontakt.ru/index.php?route=module/table/error');
		}
	}
	
	public function saveToDB($artikuls, $name, $email2, $msg, $kolvo){
		
		$this->language->load('module/table');
		$artikuls = explode(",", $artikuls);
		$kolvo = explode(",", $kolvo);
		$first = TRUE;
		$date = $today = date("d.m.y");
		
		$sql = "INSERT INTO `".DB_PREFIX."product_template` (`date`,`name`,`phone`,`email`,`artikul`,`description`,`stoimost`,`kolvo`) VALUES "; 
		$i = 0;
		foreach ($artikuls as $artikul) {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_excel` WHERE `kod_zakaza` = '" . $artikul . "'");
			foreach ($query->rows as $result) {
				$md = $result['material_description'];
				$stoimost = $result['stoimost'];
			}
			$first = FALSE;
			$sql .= "('$date','$name','$msg','$email2','$artikul','$md','$stoimost','$kolvo[$i]')";
			$sql .= ($first) ? "\n" : ",\n";
			$i++;
		}
		$sql = substr_replace($sql, ';', strrpos($sql, ','));
		if (!$first) {
			$this->db->query($sql);
			// $this->db->query($sql_user);
		}
		return TRUE;
	}
}
?>