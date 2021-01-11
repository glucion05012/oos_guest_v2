        <div class='errormsg'>
            <?php echo validation_errors(); ?>
        </div>

        <!-- ks breadcrumb begin -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="card-link" href="<?php echo base_url().$_SESSION['qr'] ?>"><?php echo $getBranch['name']; ?></a>
                </li>
                <li class="breadcrumb-item"><a href="#">
                    <a class="card-link"  href="<?php echo base_url('category'); ?>">Categories</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Menu Items</li>
            </ol>
        </nav>
        <!-- breadcrumb end -->

        <!-- checkout button begin -->
        <!-- <form action='<?php //echo base_url('items/checkout'); ?>' method='post' accept-charset='utf-8'>
            <button type='submit' class='btn s-primary-btn btn-lg checkoutbtn'>
                Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 20">
                    <path fill-rule="evenodd" d="M5.5 3.5a2.5 2.5 0 0 1 5 0V4h-5v-.5zm6 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                    </svg>
            </button>
        </form>
        <?php //if($countBagItems > 0): ?>
            <span class="badge badge-pill badge-primary itemCount"><?php //echo $countBagItems; ?></span>              
        <?php //endif; ?> -->
        <!-- checkout button end -->

        <!-- ks header begin -->
        <header>
            <div class="container-fluid" style="height:139px;color:#212529;">
                <div class="blockquote text-center header-label" style="position:relative;top:50%;-ms-transform: translateY(-50%);transform: translateY(-50%);">
                    <h1 class="align-middle">
                        <?php foreach ($food_menu_tb as $fmt) {
                            echo $fmt['category'];
                            break 1;
                        }
                        ?>
                    </h1>
                    <hr>
                </div>
            </div>
        </header>
        
        <!-- header end -->
        <!-- ks item cards begin -->
        <main class="container-fluid my-3">
            <!-- <div class="row items-container col-12 px-2"> -->
            <div class="card-deck col-lg-10 col-md-10 col-sm-10 col-xl-10 mx-auto">
                <!-- ks single item card (with container) begin -->
                <?php foreach ($food_menu_tb as $fmt){

                    $image = base_url().'assets/food_menu_images/'. $fmt['image'];
                    $menuID = $fmt['menu_id'];
                    $name = $fmt['name'];
                    $category = $fmt['category'];
                    $desc = $fmt['description'];
                    $amt = number_format($fmt['amount'],2);
                    $token = $_SESSION['token'];
                    $selectedBranch = $_SESSION['selectedBranch'];
                    $aQty = $fmt['quantity'];
                    $url = base_url('add_cart');
                    
                    echo"
                        <div class='col-lg-4 col-md-6 col-sm-6 col-12 my-3'>
                            <form action='$url' method='post' accept-charset='utf-8'>
                                <div class='card item-card mx-auto'>
                                    <input type='hidden' name='token' value='$token'>
                                    <input type='hidden' name='branchid' value='$selectedBranch'>
                                    <input type='hidden' name='menuid' value='$menuID'>
                                    <input type='hidden' name='menuitem' value='$name'>
                                    <input type='hidden' name='price' value='$amt'>
                                    <input type='hidden' name='img' value='$image'>
                                    <input type='hidden' name='category' value='$category'>
                                    <input type='hidden' name='aQty' value='$aQty'>

                                    <img src='$image' class='card-img-top' alt='image'>
                                    <h4>
                                        <span class='badge badge-pill badge-price'>₱ $amt</span>
                                    </h4>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$name</h5>
                                        <div class='comment'>
                                        $desc
                                        </div>
                                    </div>
                                    <div class='d-flex flex-row d-flex justify-content-end bd-highlight mb-3 addtocartcardcontainer'>
                                        <div class='p-2 bd-highlight col-6 addtocartcardcolumn'>
                                            <div class='input-group input-group-itemcard px-0 input-group-sm mb-3'>
                                                <input type='number' min='1' max='$aQty' name='quantity' class='form-control quantity' value='1' aria-label='Example text with button addon' aria-describedby='button-addon1' data-toggle='tooltip' data-placement='top' title='Quantity to add' required>
                                                <div class='input-group-append' data-toggle='tooltip' data-placement='top' title='Quantity available'>
                                                    <span class='input-group-text' id='basic-addon2'>/$aQty pcs</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='p-2 bd-highlight addtocartcardcolumn'>
                                            <button type='submit' class='btn btn-sm btn-addtocart' data-toggle='tooltip' data-placement='top' title='Add to tray' id='addtocart'>
                                                <i class='fas fa-shopping-bag btn-fa-shopping-bag fa-sm'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    ";

                } ?>
                <!-- single item card (with container) end -->
            </div>
        </main>
        <!-- item cards end -->

        <!-- alert codes begin -->
        <div class='row p-0 m-0' style="position:fixed;top:20%;width:100%;" >
            <?php if($this->session->flashdata('successmsg')): ?>
                <div class="alert alert-success px-5 my-2 mx-auto" role="alert">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <?php echo $this->session->flashdata('successmsg'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('errormsg')): ?>
                <div class="alert alert-danger px-5 my-2 mx-auto" role="alert">
                    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                    <?php echo $this->session->flashdata('errormsg'); ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- alert codes end -->  
