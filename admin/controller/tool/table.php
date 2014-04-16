<?php 
class ControllerToolTable extends Controller { 
	private $error = array();
	
	public function index() {		
		$this->language->load('tool/table');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/table', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$emails = $this->fromDB();
		$this->data['goods'] = $this->goodsfromDB($emails);
		$this->data['emails'] = $emails;
		$this->data['delete'] = $this->language->get('delete');
		$this->data['delete_link'] = $this->url->link('tool/table/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->template = 'tool/table.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function fromDB() {
		$this->language->load('tool/table');
		$query_emails = $this->db->query("SELECT DISTINCT `email` FROM `" . DB_PREFIX . "product_template`");
				
		if ($query_emails->num_rows > 0) {
			foreach ($query_emails->rows as $result) {
				$emails[] = array(
					'email' => $result['email']
				);
			}
		}else{
			return FALSE;
		}
	return $emails;	
	}
	
	public function goodsfromDB($emails=NULL) {
		$this->language->load('tool/table');
		if($emails!=NULL){
			foreach($emails as $email){
				$query_goods = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_template` WHERE `email`='".$email['email']."'");
				if ($query_goods->num_rows > 0) {
					foreach ($query_goods->rows as $result) {
						$n = $email['email'];
						$goods[$n][] = array(
							'phone' => $result['phone'],
							'name' => $result['name'],
							'artikul' => $result['artikul'],
							'description' => $result['description'],
							'stoimost' => $result['stoimost'],
							'kolvo' => $result['kolvo']
						);
					}
				}else{
					return FALSE;
				}
			$n++;	
			}
			return $goods;
		}
			return FALSE;
	}

	public function delete() {
		$this->language->load('tool/table');
		$name = $this->request->get['name'];
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_template` WHERE `email`='".$name."'");
		$this->redirect('http://electro-kontakt.ru/admin/index.php?route=tool/table&token='. $this->session->data['token'], 'SSL');	
	}	
}
?>