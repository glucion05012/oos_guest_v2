<?php
class Post_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    public function test(){
        $query = $this->db->get('food_menu_tb');
        return $query->result_array();
    }
    public function getMenuItems(){
        $query = $this->db->get('food_menu_tb');
        return $query->result_array();
    }
    public function getCategoryItems($category){
        $strTemp = str_replace("%20"," ", $category);
        $query = $this->db->get_where('food_menu_tb', array('category'=>$strTemp,'branch_id'=>$_SESSION['selectedBranch']));
        return $query->result_array();
    }
    public function getBranches(){
        $query = $this->db->get('hotel_branch_tb');
        return $query->result_array();
    }
    public function checkPromoCode(){
        $query = $this->db->get('promo_codes_tb');
        return $query->result_array();
    }

    // public function addCart(){
    //     date_default_timezone_set('Asia/Manila');
    //     $date_log = date('F j, Y g:i:a  ');

    //     $data = array(
    //         'token' =>$this->input->post('token'),
    //         'branch_id' => $this->input->post('branchid'),
    //         'menu_id' => $this->input->post('menuid'),
    //         'qty' => $this->input->post('quantity'),
    //         'datetime' => $date_log,
    //     );
    //     $this->db->insert('cart_list_tb', $data);

    //     return true;
    // }
    // public function addCart(){

    //     $currentToken = $_SESSION['token'];
    //     $currentMenuId = $this->input->post('menuid');
    //     $getBagItems = $this->db->query("SELECT * from cart_list_tb 
    //     where menu_id = '$currentMenuId' AND token = '$currentToken'");
    //     if ($getBagItems->num_rows() > 0){
    //         $existingRow = $getBagItems->row_array();
    //         $newQty = $existingRow['qty'] + $this->input->post('quantity');
    //         $myQuery = $this->db->query("UPDATE cart_list_tb set qty = '$newQty' 
    //         WHERE menu_id = '$currentMenuId' AND token = '$currentToken' ");
    //     }else{
    //         date_default_timezone_set('Asia/Manila');
    //         $date_log = date('F j, Y g:i:a  ');
    
    //         $dataBagItem = array(
    //             'token' =>$this->input->post('token'),
    //             'branch_id' => $this->input->post('branchid'),
    //             'menu_id' => $this->input->post('menuid'),
    //             'qty' => $this->input->post('quantity'),
    //             'datetime' => $date_log,
    //         );
    //         $this->db->insert('cart_list_tb', $dataBagItem);
    //     }

    //      return true;
    // }
    // public function getCart(){

    //     $currentToken = $_SESSION['token'];
	// 	$currentBranch = $_SESSION['selectedBranch'];
    //     //$query = $this->db->get('cart_list_tb');
    //     $query = $this->db->query("SELECT cart_list_tb.qty as orderedQty,
    //     cart_list_tb.cart_id,
    //     food_menu_tb.menu_id,
    //     food_menu_tb.category,
    //     food_menu_tb.name,
    //     food_menu_tb.quantity as availableQty,
    //     food_menu_tb.image,
    //     food_menu_tb.amount
    //     from cart_list_tb
    //     left join food_menu_tb
    //     on cart_list_tb.menu_id = food_menu_tb.menu_id 
    //     WHERE food_menu_tb.branch_id = '$currentBranch' AND cart_list_tb.token = '$currentToken'");

    //     return $query->result_array();
    // }
    public function valid_tray_qty($menuId, $orderedQty){
        $query = $this->db->get_where('food_menu_tb', array('menu_id'=>$menuId, 'branch_id'=>$_SESSION['selectedBranch']));
        $itemRow = $query->row_array();
        if ($orderedQty <= $itemRow['quantity']){
            return true;
        }else{
            return false;
        }
    }
    public function check_promo(){
        $query = $this->db->get_where('promo_codes_tb', array('promo_code'=>$_POST["promoCode"]));
        return $query->result_array();
    }
    public function getOrderDetails($orderRefNo){
        $query = $this->db->query("SELECT 
        orders_tb.name as customerName,
        hotel_branch_tb.name as branchName,
        orders_tb.order_status,
        orders_tb.datetime_ordered,
        orders_tb.datetime_checkin,
        orders_tb.room_no,
        orders_tb.datetime_delivered,
        food_menu_tb.name as itemName,
        ordered_items_tb.quantity,
        orders_tb.promo_code,
        orders_tb.promo_percent,
        orders_tb.promo_amt,
        orders_tb.reference_number,
        orders_tb.total_amount,
        food_menu_tb.image,
        ordered_items_tb.menu_amt,
        food_menu_tb.description,
        food_menu_tb.category
        from orders_tb
        left join ordered_items_tb 
        on orders_tb.order_id = ordered_items_tb.order_id
        left join hotel_branch_tb
        on orders_tb.branch_id = hotel_branch_tb.branch_id
        left join food_menu_tb
        on ordered_items_tb.menu_id = food_menu_tb.menu_id
        WHERE orders_tb.reference_number = '$orderRefNo'");
        $rowCount = $query->num_rows();

        if ($rowCount == 0){
            return false;
        }else{
            return $query->result_array();
        }


    }
    // public function item_remove($id){
    //     $this->db->where('cart_id', $id);
    //     $this->db->delete('cart_list_tb');
    //     return true;
    // }
    // public function countBagItems(){
    //     $query = $this->db->get_where('cart_list_tb', array('token'=>$_SESSION['token']));
    //     return $query->num_rows();
    // }
    public function checkRefNoExist($rn){
        $query = $this->db->get_where('orders_tb', array('reference_number'=>$rn));
        $query->num_rows();
        if ($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function newOrder(){

        //saving orders and ordered menu
        //randomize 6 char string for ref id
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $refNo = substr(str_shuffle($str_result), 0, 6);
        while($this->checkRefNoExist($refNo)){
            //will keep randomizing until new Ref no is unique
            $refNo = substr(str_shuffle($str_result), 0, 6);
        }

        // gets date
        date_default_timezone_set('Asia/Manila');
        $date_log = date("Y-m-d H:i:s");

        // sets value to checkbox. 0 if checked, 1 if unchecked
        $checkinVal=0;
        if (null !== $this->input->post('checkedIn') && $this->input->post('checkedIn') == "0"){
            $checkinVal = 0;
        }else{
            $checkinVal = 1;
        }        

        //gets discount value from promo codes
        $promoPerCent = 0;
        $promocodeVal = 0;
        
        $promoCode = $this->input->post('promo_code');
        $getPromoQuery = $this->db->query("SELECT * from promo_codes_tb where promo_code = '$promoCode'");
        if ($getPromoQuery->num_rows() > 0){
            $promoRow = $getPromoQuery->row_array();
            $promoPerCent = $promoRow['percent'];
            $promocodeVal = $promoRow['amount'];

            if ($promoPerCent == 1){
                $undiscounted = $this->input->post('subtotal');
                // $promocodeVal = $undiscounted * ($promocodeVal * 0.01);
            }
        }else{
            $promocodeVal = '';
            $promoPerCent = '';
            $promoCode = '';
        }

        //insert order query
        $orderData = array(
            'datetime_ordered' =>$date_log,
            'notes' => $this->input->post('orderNotes'),
            'total_amount' => $this->input->post('subtotal'),
            'promo_percent' => $promoPerCent,
            'promo_code' => $promoCode,
            'promo_amt' => $promocodeVal,
            'order_status' => "PLACED",
            'name' => $this->input->post('customerName'),
            'contact' => $this->input->post('contactNumber'),
            'room_no' => $this->input->post('roomNo'),
            'advance_order' => $checkinVal,
            'branch_id' => $_SESSION['selectedBranch'],
            'reference_number' => $refNo,
            'longlat' => $this->input->post('longlat')
        );
        // executes insert query
        $this->db->insert('orders_tb', $orderData);

        

        // returns the latest row saved in orders_tb from above
        $insertedOrderId = $this->db->insert_id();
        $getOrderQuery = $this->db->get_where('orders_tb', array('order_id'=>$insertedOrderId));

        //inserts each array of items from tray to ordered_items_tb
        foreach($_SESSION['trayItems'] as $row){
			if (isset($row[0]['menu_id'])){
                $dataBag = array(
                    'menu_amt' => $row[0]['price'],
                    'menu_id' => $row[0]['menu_id'],
                    'order_id' => $insertedOrderId,
                    'quantity' => $row[0]['qty']
                );
                // executes insert query
                $this->db->insert('ordered_items_tb', $dataBag);
                
                //update qty of food_menu_tb
                $currentMenuID = $row[0]['menu_id'];
                $orderedQty = $row[0]['qty'];
                $currentQtyQuery = $this->db->get_where('food_menu_tb', array('menu_id'=>$currentMenuID));
                $currentQtyArray = $currentQtyQuery->row_array();
                $currentQty = $currentQtyArray['quantity'] - $row[0]['qty'];
                $this->db->query("UPDATE food_menu_tb set quantity = $currentQty WHERE menu_id = '$currentMenuID'");
                //$this->db->query("UPDATE food_menu_tb set quantity = ((SELECT quantity from food_menu_tb WHERE menu_id = '$currentMenuID')-$orderedQty) WHERE menu_id = '$currentMenuID' ");
        
            }
        }
        //empty tray array
        unset($_SESSION['trayItems']);

        return $getOrderQuery->result_array();

    }
    public function getBranchName(){
        $currentBranch = $_SESSION['selectedBranch'];
        $query = $this->db->query("select name from hotel_branch_tb where branch_id = '$currentBranch'");
        return $query->row_array();
    }
}
?>