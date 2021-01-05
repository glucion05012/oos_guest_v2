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
		$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove
		$this->load->view('templates/header');
		$this->load->view('BranchSelection',$data);
		$this->load->view('templates/footer', $data);
	}
	public function category()
	{
		$data['getBranch'] = $this->post_model->getBranchName(); //for branch name on breadcrumb
		$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove
		//$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
		$data['food_uncatmenu_tb'] =  $this->post_model->getMenuItems();
		$this->load->view('templates/header', $data);
		$this->load->view('home',$data);
		$this->load->view('templates/footer');
	}
	public function items($category)
	{
		$data['getBranch'] = $this->post_model->getBranchName(); //for branch name on breadcrumb
		//$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
		$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove
		$data['food_menu_tb'] =  $this->post_model->getCategoryItems($category);
		$data['countBagItems'] = $this->post_model->countBagItems();
		$data['getCart'] =  $this->post_model->getCart();
		$this->load->view('templates/header', $data);
		$this->load->view('items', $data);
		$this->load->view('js/alerts');
		$this->load->view('templates/footer');
	}
	public function checkout()
	{
		$data['getBranch'] = $this->post_model->getBranchName(); //for branch name on breadcrumb
		//$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
		$this->form_validation->set_rules("subtotal","subtotal","required");
		if($this->form_validation->run() === FALSE){
			$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove
			$data['food_uncatmenu_tb'] =  $this->post_model->getMenuItems();
			$data['getCart'] =  $this->post_model->getCart();

			$this->load->view('templates/header', $data);
			$this->load->view('checkout',$data);
			$this->load->view('js/alerts');
			$this->load->view('templates/footer');
			$this->load->view('js/checkout');
			
		}else{
			// place order
			
			$data['refNo'] = $this->post_model->newOrder();
			if ($data['refNo'] == FALSE){
				$this->session->set_flashdata('errormsg', 'Ordered quantity cannot be larger than the available quantity. Please check your items!');
				$url = $_SERVER['HTTP_REFERER'];
                redirect($url);
			}else{
				$referenceNo = json_encode($data['refNo'][0]['reference_number']);
				$_SESSION['refNo'] =  trim($referenceNo, '"');
				redirect("post-order");
			}
		}
	}
	public function postOrderPage(){
		
		$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove

		// echo json_encode($data['newOrder']);
		
		$this->load->view('templates/header');
		$this->load->view('postOrder', $data);
		$this->load->view('templates/footer',$data);
	}
	public function createSession(){
		
		session_start();
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()-+'; 
		
		$_SESSION['token'] = substr(str_shuffle($str_result), 0, 20); 
		$_SESSION['selectedBranch'] = $this->input->post('selectedBranch');
		
		redirect('category');
	}

	public function add_cart(){

		$this->post_model->addCart();
		$this->session->set_flashdata('successmsg', 'Item Added to tray');
			
		$url = $_SERVER['HTTP_REFERER'];
		redirect($url);
	}

	public function check_promo(){
		$res = $this->post_model->check_promo();
		echo json_encode($res);
	}

	public function item_remove($id){
		$this->post_model->item_remove($id);
		
		$url = $_SERVER['HTTP_REFERER'];
            redirect($url);
	}

	public function updateBagItemQty(){
		$this->post_model->updateBagItemQty();


		// echo $_POST['menuid'];
		// echo $_POST['inputQty'];
		// echo $_SESSION['token'];
	}

	public function trackOrder(){
		$data['getPromoCode'] =  $this->post_model->checkPromoCode();// do not remove
		$data['getOrderDetails'] = $this->post_model->getOrderDetails();
		//echo $_POST['orderRefNo'];
		//echo json_encode($data['getOrderDetails']);

		// proceed to load the next page if data is returned

		
		if($this->post_model->getOrderDetails()){
			$this->load->view('templates/header');
			$this->load->view('orderTracking', $data);
			$this->load->view('templates/footer',$data);
		}else{
			$data['getBranches'] =  $this->post_model->getBranches();// for branch selection
			$this->session->set_flashdata('successmsg', 'Order reference number not found!');
			
			$this->load->view('templates/header');
			$this->load->view('BranchSelection',$data);
			$this->load->view('js/alerts');
			$this->load->view('templates/footer',$data);
		}
	}
}