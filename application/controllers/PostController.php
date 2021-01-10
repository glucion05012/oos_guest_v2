<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends CI_Controller {


	public function test()
	{
		$data['food_menu_tb'] =  $this->post_model->getMenuItems();
		$this->load->view('templates/header');
		$this->load->view('items',$data);
		$this->load->view('templates/footer');
		// $data['test'] =  $this->post_model->test();
		// echo json_encode($data['test']);
	}
	public function index(){
		$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
		$this->load->view('templates/header');
		$this->load->view('BranchSelection',$data);
		$this->load->view('templates/footer');
	}
	public function category()
	{
		if (isset($_SESSION['token'])){
			//validate order qty vs available qty from db
			foreach($_SESSION['trayItems'] as &$row){
				if (isset($row[0]['menu_id'])){
					$data['valid'] = $this->post_model->valid_tray_qty($row[0]['menu_id'], $row[0]['qty']);
					if($data['valid'] == false){
						$this->session->set_flashdata('errormsg', 'You can\'t order more than what is available');
						unset($row[0]);
					}
				}
			}
			
			$data['getBranch'] = $this->post_model->getBranchName(); //for getting selected branch's name
			$data['food_uncatmenu_tb'] =  $this->post_model->getMenuItems();
			$this->load->view('templates/header');
			$this->load->view('home',$data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/footer');
		}else{
			$this->index();
		}

	}
	public function items($category)
	{
		
		if (isset($_SESSION['token'])){

			//validate order qty vs available qty from db
			foreach($_SESSION['trayItems'] as &$row){
				if (isset($row[0]['menu_id'])){
					$data['valid'] = $this->post_model->valid_tray_qty($row[0]['menu_id'], $row[0]['qty']);
					if($data['valid'] == false){
						$this->session->set_flashdata('errormsg', 'You can\'t order more than what is available');
						unset($row[0]);
					}
				}
			}

			$data['getBranch'] = $this->post_model->getBranchName(); //for getting selected branch's name
			$data['food_menu_tb'] =  $this->post_model->getCategoryItems($category);
			$this->load->view('templates/header');
			$this->load->view('items', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('js/alerts');
			$this->load->view('templates/footer');
		}else{
			$this->index();
		}
	}
	public function checkout()
	{
		if (isset($_SESSION['token'])){
			$data['getBranch'] = $this->post_model->getBranchName(); //for getting selected branch's name
			$this->form_validation->set_rules("subtotal","subtotal","required");
			if($this->form_validation->run() === FALSE){
				$data['food_uncatmenu_tb'] =  $this->post_model->getMenuItems();//for items display on checkout

				$this->load->view('templates/header');
				$this->load->view('checkout',$data);
				$this->load->view('js/alerts');
				$this->load->view('templates/footer');
				$this->load->view('js/checkout');
				
			}else{
				// place order
				
				$data['refNo'] = $this->post_model->newOrder();
				if ($data['refNo'] == FALSE){
					$this->session->set_flashdata('errormsg', 'You can\'t order more than what is available');
					$url = $_SERVER['HTTP_REFERER'];
					redirect($url);
				}else{
					$referenceNo = json_encode($data['refNo'][0]['reference_number']);
					$_SESSION['refNo'] =  trim($referenceNo, '"');
					redirect("post-order");
				}
			}
		}else{
			$this->index();
		}
		
	}
	public function postOrderPage(){

		if (isset($_SESSION['token'])){
			$this->load->view('templates/header');
			$this->load->view('postOrder');
			$this->load->view('templates/footer');
		}else{
			$this->index();
		}

	}
	public function createSession(){
		
		session_start();
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()-+'; 
		
		$_SESSION['token'] = substr(str_shuffle($str_result), 0, 20); 
		$_SESSION['selectedBranch'] = $this->input->post('selectedBranch');
		
		//array for sidebar items (tray)
		$_SESSION['trayItems'] = array();

		redirect('category');
	}

	public function add_cart(){

		$postedMenuId = $this->input->post('menuid');
		$postedQty = $this->input->post('quantity');
		$postedItem = $this->input->post('menuitem');
		$postedPrice = $this->input->post('price');
		$postedImg = $this->input->post('img');
		$postedCategory = $this->input->post('category');
		$postedAQty = $this->input->post('aQty');

		$menuExists = false;
		//check if menu_id is already in the array
		foreach($_SESSION['trayItems'] as &$row){
			if (isset($row[0]['menu_id'])){
				if ($row[0]['menu_id'] === $postedMenuId){ //if it exists, attempt to update qty
					$newQty = ($row[0]['qty'] + $postedQty);

					// validate order qty vs available qty locally 
					if($newQty<=$postedAQty){
						$row[0]['qty'] = $newQty; //update ordered qty from the array
						$this->session->set_flashdata('successmsg', 'Item Added to tray');
					}else{
						$this->session->set_flashdata('errormsg', 'You can\'t order more than what is available');
					}
					$menuExists = true;
				}
			}

		}

		if($menuExists == false){
			//adds posted data as an array row to $_SESSION['trayItems']
			$newRow = array(
				array(
					"menu_id"=>$postedMenuId,
					"item"=>$postedItem,
					"qty"=>$postedQty,
					"price"=>$postedPrice,
					"image"=>$postedImg,
					"category"=>$postedCategory
				)
			);
			array_push($_SESSION['trayItems'], $newRow);
			//assigning posted values as an array
			$this->session->set_flashdata('successmsg', 'Item Added to tray');
		}
		
		
			
		// refreshes the page
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url);
	}

	public function check_promo(){
		$res = $this->post_model->check_promo();
		echo json_encode($res);
	}

	//public function item_remove($id){
	public function item_remove($id){

		foreach($_SESSION['trayItems'] as &$row){
			if (isset($row[0]['menu_id'])){
				if ($row[0]['menu_id'] === $id){ //if it exists in the row, update qty
					unset($row[0]);
					break;
				}
			}
		}
		
		$this->session->set_flashdata('successmsg', 'Item removed from tray');
		
		// refreshes the page
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url);
	}

	public function updateBagItemQty(){

		$this->post_model->updateBagItemQty();

	}

	public function trackOrder(){

		$data['getOrderDetails'] = $this->post_model->getOrderDetails();

		// proceed to load the next page if data is returned

		if($this->post_model->getOrderDetails()){
			$this->load->view('templates/header');
			$this->load->view('orderTracking', $data);
			$this->load->view('templates/footer');
		}else{
			$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
			$this->session->set_flashdata('successmsg', 'Order reference number not found!');
			
			$this->load->view('templates/header');
			$this->load->view('BranchSelection',$data);
			$this->load->view('js/alerts');
			$this->load->view('templates/footer');
		}
	}
}