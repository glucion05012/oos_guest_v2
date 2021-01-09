
        <!-- ks breadcrumb begin -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                <a class="card-link" href="<?php echo base_url(); ?>"><?php echo $getBranch['name']; ?></a>
                </li>
                <li class="breadcrumb-item"><a href="#">
                    <a class="card-link"  href="<?php echo base_url('category'); ?>">Categories</a>
                </li>

                <?php 
                $category = "sandwiches";
                
                foreach($_SESSION['trayItems'] as $row){
                    if (isset($row[0]['menu_id'])){
                        $category = $row[0]['category'];
                    }
                };

                ?>

                <li class='breadcrumb-item'>
                    <a class='card-link'  href="<?php echo base_url('items/'.$category); ?>">Menu Items</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <!-- breadcrumb end -->
        <header>
            <div class="container-fluid" style="height:139px;color:#212529;">
                <div class="blockquote text-center header-label" style="position:relative;top:50%;-ms-transform: translateY(-50%);transform: translateY(-50%);">
                    <h1 class="align-middle">Checkout</h1>
                    <hr>
                </div>
            </div>
        </header>
        <main>
            <form class="create-form" action="<?= base_url('items/checkout'); ?>" method="post" accept-charset="utf-8">
                <div class="container-fluid my-3">
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-10 col-md-10 col-lg-9 mx-auto">
                            <!-- ks row container for items section header -->
                            <div class="row px-0">
                                <div class="col-12">
                                    <div class="checkoutstepsheader">
                                        <h5>1. Order Summary</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mx-auto col-sm-3 checkoutImgCol tableRowHeader">
                                            <h6 class="mx-auto">Image</h6>
                                        </div>
                                        <div class="col-12 col-sm-9">
                                            <div class="row">
                                                <div class="col-4 tableRowHeader">
                                                    <h6 class="mx-auto">Menu Item</h6>
                                                </div>
                                                <div class="col-4 tableRowHeader">
                                                    <h6 class="mx-auto">Quantity</h6>
                                                </div>
                                                <div class="col-4 tableRowHeader">
                                                    <h6 class="mx-auto">Price</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="col-12 mx-auto;">

                            <!-- ks row container for items -->
                            <?php 
                            
                            $total_amt = 0;
                            
                            foreach ($_SESSION['trayItems'] as $row){
                                if (isset($row[0]['menu_id'])){
                                    $image = $row[0]['image'];
                                    $name = $row[0]['item'];
                                    $qty = $row[0]['qty'];//cartQty
                                    $menuID = $row[0]['menu_id'];
                                    $amt = number_format($row[0]['price'],2);//food_menu_tb
                                    // computation
                                    $rowPrice = $qty * $amt;
                                    $total_amt = $total_amt + $rowPrice;
                                    
                                    echo "
                                    <div class='row'>
                                        <div class='col-12'>
                                            <div class='row itemRow'>
                                                <div class='col-12 col-sm-3 checkoutImgCol mx-auto'>
                                                    <img class='img-thumbnail checkout-item-img my-2' src='$image' alt=''>
                                                </div>
                                                <div class='col-12 col-sm-9'>
                                                    <div class='row'>
                                                        <div class='d-flex bd-highlight col-12 col-md-4'>
                                                            <div class='p-2 bd-highlight tableColumnHeader checkoutFlexItem'>
                                                                <h6>Menu Item</h6>
                                                            </div>
                                                            <div class='p-2 bd-highlight mx-auto checkoutFlexItem itemTableInfo'>
                                                                $name
                                                            </div>
                                                            <input type='hidden' name='menu_id' id ='menu_id-$menuID' value='$menuID'>
                                                        </div>
                                                        <div class='d-flex bd-highlight col-12 col-md-4'>
                                                            <div class='p-2 bd-highlight checkoutFlexItem tableColumnHeader'>
                                                                <h6>Quantity</h6>
                                                            </div>
                                                            <div class='p-2 bd-highlight mx-auto checkoutFlexItem itemTableInfo' data-toggle='tooltip' data-placement='top' title='Quantity (Ordered / Available)'>
                                                                $qty pc(s)
                                                            </div>
                                                        </div>
                                                        <div class='d-flex bd-highlight col-12 col-md-4'>
                                                            <div class='p-2 bd-highlight checkoutFlexItem tableColumnHeader'>
                                                                <h6>Price</h6>
                                                            </div>
                                                            <div class='p-2 bd-highlight mx-auto checkoutFlexItem itemTableInfo'>
                                                                ₱ $amt
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                    </div>
    
                                    <hr class='col-12 mx-auto;'>
                                    ";
                                }
                                

                            }; ?>

                            <!-- ks row container for pricing summary and promo code input -->
                            <div class="col-lg-5 col-md-6 col-sm-7 col-12 pricingsummary">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- new promo code -->
                                        <div class="input-group" data-toggle='tooltip' data-placement='top' title='Apply Promo Code' id="promo_code_div">
                                            <input type="text" class="form-control" placeholder="Promo Code" aria-label="Recipient's username" aria-describedby="button-addon2" id="promo_code" name="promo_code">
                                            <div class="input-group-append">
                                                <button class="btn s-secondary-btn apply_promo" type="button" id="button-addon2" name='apply_promo'>Apply<i class="ml-2 fas fa-tag"></i></button>
                                            </div>
                                        </div>
                                        <div class = "mb-3"><small class ="promoCodeError"></small></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <?php
                                    // $total_amt = 0;
                                    // foreach ($getCart as $gct){
                                    //     if($_SESSION['token'] == $gct['token']){
                                    //         foreach ($food_uncatmenu_tb as $fmt){
                                    //             if($gct['menu_id'] == $fmt['menu_id']){

                                    //                 $qty = $gct['qty'];
                                    //                 $amt = $fmt['amount'];

                                    //                 $total_amt += floatval($amt) * intval($qty);
                                    //             };
                                    //         };
                                    //     };
                                    // };
                                    ?>
                                        <h6>Subtotal:</h6>
                                    </div>
                                    <div class="col" style="text-align:right;">
                                    <input type="hidden" id="subtotal" value="<?php echo $total_amt; ?>" name="subtotal">
                                        <h6>₱ <?php echo number_format($total_amt,2); ?></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h6>Discount:</h6>
                                    </div>
                                    <div class="col" style="text-align:right;">
                                        <h6><span id="discount"></span></h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-5">
                                        <h6>Total Amount:</h6>
                                    </div>
                                    <div class="col-7" style="text-align:right;">
                                        <h3><span id="total">₱ <?php echo number_format($total_amt,2); ?></span></h3>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <!-- row container for information -->
                    <div class="row mx-auto" style="margin-top:20px;margin-bottom:20px;">
                        <div class="col-10 col-md-10 mx-auto">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mx-auto">
                                    <div class="checkoutstepsheader" style="width:100%;">
                                        <h5>2. Contact Information</h5>
                                    </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="checkedIn" name="checkedIn" value = "0">
                                            <label class="form-check-label" for="checkedIn">Already checked in?</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="roomNumber" >Room Number</label>
                                            <input type="text" class="form-control" id="roomNumber" name="roomNo" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="customerName">Customer Name</label>
                                            <input type="text" class="form-control" id="customerName" name="customerName">
                                        </div>
                                        <div class="form-group">
                                            <label for="contactNumber">Contact Number</label>
                                            <input type="text" class="form-control" id="contactNumber" name="contactNumber">
                                        </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mx-auto">
                                    <div class="checkoutstepsheader" style="width:100%;">
                                        <h5>3. Order Information</h5>
                                    </div>
                                    <div class="form-group">
                                        <label for="orderNotes">Order notes</label>
                                        <textarea type="text" class="form-control" id="orderNotes" aria-describedby="orderDesc" rows=3 name="orderNotes"></textarea>
                                        <small id="orderDesc" class="form-text text-muted">Special instructions/notes</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <button class="btn s-primary-btn mx-auto btn-lg col-10 col-lg-3 col-md-5" type="submit" name="button" value="placeOrder" data-toggle='tooltip' data-placement='top' title='Confirm Order'>Place Order</button>
                    </div>
                </div>
            </form>
            
        </main>
        <!-- alert codes begin -->
        <div class='row p-0 m-0' style="position:fixed;top:20%;width:100%;" >
            <?php if($this->session->flashdata('errormsg')): ?>
                <div class="alert alert-warning px-5 my-2 mx-auto" role="alert">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <?php echo $this->session->flashdata('errormsg'); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- alert codes end -->  