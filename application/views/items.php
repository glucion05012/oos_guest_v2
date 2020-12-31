        <div class='errormsg'>
            <?php echo validation_errors(); ?>
        </div>

        <!-- ks breadcrumb begin -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#"><a class="card-link" href="<?php echo base_url(); ?>">Branch Selection</a></a>
                </li>
                <li class="breadcrumb-item"><a href="#">
                    <a class="card-link"  href="<?php echo base_url('category'); ?>">Categories</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Menu Items</li>
            </ol>
        </nav>
        <!-- breadcrumb end -->

        <div id="mySidebar" class="d-flex flex-column sidebar">
            <!-- sidebar header -->
            <div class="p-2 col-sm sidebarheader">
                <h2 style="padding-top:40px;">Your bag</h2>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <?php foreach ($getBranches as $brnch) {
                            if($brnch['branch_id'] == $_SESSION['selectedBranch']){
                                $brnch = $brnch['name'];
                                echo "<h6 id='branchIndicator'>Branch: $brnch</h6>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- sidebar item list -->
            <div class="p-2 sidebarContainer overflow-auto">
                <ul class="list-group list-group-flush bag-items-list">
                    <?php foreach ($getCart as $gct){
                        if($_SESSION['token'] == $gct['token']){
                            foreach ($food_menu_tb as $fmt){
                                if($gct['menu_id'] == $fmt['menu_id']){
                                    $image = base_url().'assets/food_menu_images/'. $fmt['image'];
                                    $name = $fmt['name'];
                                    $qty = $gct['qty'];
                                    $menuID = $fmt['menu_id'];
                                    $amt = $fmt['amount'];

                                    echo"

                                    <li class='list-group-item bg-transparent'>
                                        <a href='#' style='position:absolute;top:2px;right:5px;' data-toggle='tooltip' data-placement='top' title='remove'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x text-muted' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                            </svg>
                                        </a>
                                        <table class='table-borderless' style='width:100%;padding:0;'>
                                            <tr>
                                                <td scope='col' rowspan='2' style='width:90px;'>
                                                    <img src='$image' class='img-fluid' alt='...'>
                                                </td>
                                                <td colspan='2'><h6 class='mt-0'>$name</h6></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type='number' value='$qty' name='quantity' class='form-control quantity' id='$menuID' aria-label='Example text with button addon' aria-describedby='button-addon1'>
                                                    </input>
                                                </td>
                                                <td>
                                                    <h6 style='padding-top:6px;text-align:right;'>₱ $amt</h6>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>

                                    ";
                                };
                            };
                        };

                    }; ?>
                </ul>
            </div>
            <!-- sidebar footer -->
            <div class="p-2 bagfooter align-items-center">
            <hr>
                <div class="row" style="padding-top:20px;padding-bottom:40px;" >
                    <div class="col-3"><h6>Total:</h6></div>
                    <?php
                    $total_amt = 0;
                    foreach ($getCart as $gct){
                        if($_SESSION['token'] == $gct['token']){
                            foreach ($food_menu_tb as $fmt){
                                if($gct['menu_id'] == $fmt['menu_id']){

                                    $qty = $gct['qty'];
                                    $amt = $fmt['amount'];

                                    $total_amt += floatval($amt) * intval($qty);
                                };
                            };
                        };
                    };
                    ?>
                    <div class="col-9"><h3 style="text-align:right;">₱<?php echo $total_amt; ?></h3></div>
                    <!-- <form class="col-12" action="<?= base_url('checkout'); ?>" method="post" accept-charset="utf-8"> -->
                    <form class="col-12" action="<?php echo "checkout/"; ?>" method="post">
                        <button class="btn btn-lg s-primary-btn btn-sidebar-checkout" type="submit" name="button" style="margin-top:8px">Checkout</button>
                    </form>
                </div>
            </div>
            <a href="javascript:void(0)" class="s-tertiary-btn closebtn float-right" onclick="closeNav()" style="margin-right:8px;">
                <i class="fas fa-times fa-xs"></i>
            </a>
        </div>

        <!-- checkout button begin -->
        <form action='<?php echo base_url('items/checkout'); ?>' method='post' accept-charset='utf-8'>
            <button type='submit' class='btn s-primary-btn btn-lg checkoutbtn'>
                Checkout
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 20">
                    <path fill-rule="evenodd" d="M5.5 3.5a2.5 2.5 0 0 1 5 0V4h-5v-.5zm6 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                    </svg>
            </button>
        </form>
        <?php if($countBagItems > 0): ?>
            <span class="badge badge-pill badge-primary itemCount"><?php echo $countBagItems; ?></span>              
        <?php endif; ?>
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

                            if($_SESSION['selectedBranch'] == $fmt['branch_id']){
                                $image = base_url().'assets/food_menu_images/'. $fmt['image'];
                                $menuID = $fmt['menu_id'];
                                $name = $fmt['name'];
                                $desc = $fmt['description'];
                                $amt = $fmt['amount'];
                                $token = $_SESSION['token'];
                                $selectedBranch = $_SESSION['selectedBranch'];
                                $url = base_url('add_cart');

                                echo"
                                    <div class='col-lg-4 col-md-6 col-sm-6 col-12 my-3'>
                                        <form action='$url' method='post' accept-charset='utf-8'>
                                            <div class='card item-card mx-auto'>
                                                <input type='hidden' name='token' value='$token'>
                                                <input type='hidden' name='branchid' value='$selectedBranch'>
                                                <input type='hidden' name='menuid' value='$menuID'>
                                                <img src='$image' class='card-img-top' alt='image'>
                                                <h4>
                                                    <span class='badge badge-pill badge-price'>₱ $amt</span>
                                                </h4>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>$name</h5>
                                                    <p class='card-text'>$desc</p>
                                                </div>
                                                <div class='d-flex flex-row d-flex justify-content-end bd-highlight mb-3 addtocartcardcontainer'>
                                                    <div class='p-2 bd-highlight addtocartcardcolumn'>
                                                        <div class='input-group input-group-itemcard px-0 input-group-sm mb-3 col-6 float-right'>
                                                            <input type='number' min='1' name='quantity' class='form-control quantity' value='1' aria-label='Example text with button addon' aria-describedby='button-addon1' data-toggle='tooltip' data-placement='top' title='Quantity to add' required>
                                                        </div>
                                                    </div>
                                                    <div class='p-2 bd-highlight addtocartcardcolumn'>
                                                        <button type='submit' class='btn btn-sm btn-addtocart'data-toggle='tooltip' data-placement='top' title='Add to tray' id='addtocart'>
                                                            <i class='fas fa-shopping-bag btn-fa-shopping-bag fa-sm'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                ";
                            } //end if

                        // $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

                        // if($pageWasRefreshed ) {
                        //     redirect(base_url());
                        // }

                    }
                ?>
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
        </div>
        <!-- alert codes end -->  
