        <!-- sidebar begin -->
        <div id="mySidebar" class="d-flex flex-column sidebar p-3">
            <!-- sidebar header -->
            <div class="p-2 sidebarheader">
                <h2 class="pl-3 pt-3">Your tray</h2>
                <hr>
                <div class="row px-3">
                    <div class="col-12">
                        <h6><?php echo $getBranch['name']; ?></h6>
                    </div>
                </div>
            </div>
            <!-- sidebar item list -->
            <div class="p-2 sidebarContainer overflow-auto">
                <ul class="list-group list-group-flush bag-items-list">
                    <?php 
                    $itemCount = 0;
                    
                    foreach ($getCart as $cartItem){
                        $itemCount+=1;
                        $menuID = $cartItem['menu_id'];
                        $image = base_url().'assets/food_menu_images/'.$cartItem['image'];
                        $name = $cartItem['name'];
                        $orderedQty = $cartItem['orderedQty'];
                        $availableQty = $cartItem['availableQty'];
                        $price = $cartItem['amount'];

                        echo"
                        <li class='list-group-item bg-transparent'>
                            <a href='#' style='position:absolute;top:2px;right:5px;' data-toggle='tooltip' data-placement='top' title='remove'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x text-muted' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z' />
                                </svg>
                            </a>
                            <table class='table-borderless' style='width:100%;padding:0;'>
                                <tr>
                                    <td scope='col' rowspan='2' style='width:90px;'>
                                        <img src='$image' class='img-fluid' alt='...'>
                                    </td>
                                    <td colspan='2'>
                                        <h6 class='mt-0'>$name</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class ='sidebarQty input-group-sm'  data-toggle='tooltip' data-placement='top' title='Qty to order'>
                                        <input type='number' value='$orderedQty' name='$menuID-quantity' min='1' max='$availableQty' class='form-control quantity' aria-label='Example text with button addon' aria-describedby='button-addon1'>
                                        </input>
                                    </td>
                                    <td data-toggle='tooltip' data-placement='top' title='Available Qty'>&nbsp;/$availableQty
                                    </td>
                                    <td class='sidebarItemPrice''>
                                        <h6 data-toggle='tooltip' data-placement='top' title='Price'>₱".number_format($price,2)."</h6>
                                    </td>
                                </tr>
                            </table>
                        </li>";
                    }
                    
                    if ($itemCount == 0){
                        echo "<li class='list-group-item bg-transparent'><h5> You have 0 items in your tray</h5></li>";
                    }

                ?>

                </ul>
            </div>
            <!-- sidebar footer -->
            <div class="p-2 bagfooter align-items-center">
                <hr>
                <div class="row" style="padding-top:20px;padding-bottom:40px;">
                    <div class="col-3">
                        <h6>Total:</h6>
                    </div>
                    <div class="col-9">
                        <h3 style="text-align:right;">₱ 0.00</h3>
                    </div>
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
        <!-- sidebar end -->

        <!-- sidebar toggle begin -->
        <button class='btn s-primary-btn' id="sidebarbtn" onclick="openNav()">
            Tray &nbsp;
            <span class="badge badge-light">5</span>
        </button>
        <!-- sidebar toggle end -->