        <!-- ks breadcrumb begin -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="card-link" href="<?php echo base_url(); ?>"><?php echo "Branch Selection" ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Order Tracking</li>
            </ol>
        </nav>
        <!-- breadcrumb end -->
      
        <header>
            <div class="container-fluid" style="height:139px;color:#212529;">
                <div class="blockquote text-center header-label" style="position:relative;top:50%;-ms-transform: translateY(-50%);transform: translateY(-50%);">
                    <h1 class="align-middle">Order Tracking</h1>
                    <hr>
                </div>
            </div>
        </header>
        
        <?php
        // order details variables
            $refNo;
            $oStat;
            $orderedBy;
            $dateOrdered;
            $orderedFrom;
            $deliverTo;
            $dateDelivered;
            $promoCode;
            $menuAmt;
            $discountVal;
            $totalAmt;
            $discountedAmt;
            $promoPerCent;
            foreach ($getOrderDetails as $oD) {
                $refNo =  $oD['reference_number'];
                $oStat = $oD['order_status'];
                $orderedBy = $oD['customerName'];
                $dateOrdered = $oD['datetime_ordered'];
                $orderedFrom = $oD['branchName'];
                $deliverTo = $oD['room_no'];
                $dateDelivered = $oD['datetime_delivered'];
                $promoCode = $oD['promo_code'];
                $menuAmt = number_format($oD['menu_amt'],2);
                $discountVal = $oD['promo_amt']; // Order Discount
                $totalAmt = $oD['total_amount']; //Order Total
                $discountedAmt = 0;
                $promoPerCent = $oD['promo_percent'];
                break 1;
            }
            if (isset($promoCode)&& strlen($promoCode)>1){
                $discountedAmt = $totalAmt-$discountVal;
            }
            
            // // status color variables
            $cssStyle;
            if ($oStat == "PLACED"){
                $cssStyle = "style = 'background-color:#f2f2f2;color:#212529;'";
            }elseif($oStat == "RECEIVED"){
                $cssStyle = "style = 'background-color:#70B5FF;color:#FFFFFF;'";
            }elseif($oStat == "PREPARING TO COOK"){
                $cssStyle = "style = 'background-color:#007BFF;color:#FFFFFF;'";
            }elseif($oStat == "COOKING"){
                $cssStyle = "style = 'background-color:#19B3C8;color:#FFFFFF;'";
            }elseif($oStat == "FOR DELIVER"){
                $cssStyle = "style = 'background-color:#24BC94;color:#FFFFFF;'";
            }elseif($oStat == "COMPLETED"){
                $cssStyle = "style = 'background-color:#28A745;color:#FFFFFF;'";
            }elseif($oStat == "CANCELLED"){
                $cssStyle = "style = 'background-color:#fE0002;color:#FFFFFF;'";
            }

        ?>

        <div class="row mx-0 my-3">
            <div class="col-10 my-5 mx-auto">
                <div class="row">
                    <div class="col-12 mb-5 mx-auto">
                        <h5>
                            Order no.: <?php echo $refNo; ?>
                            <span class="badge badge-secondary" <?php echo $cssStyle; ?>><?php echo $oStat; ?></span>
                        </h5>
                        Ordered at <?php echo "<b>".$dateOrdered."</b> from <b>".$orderedFrom. "</b> branch" ; ?>
                        <hr>
                    </div>
                </div>
                <div class="row mx-auto">
                    <!-- order summary in card begin -->
                    <div class="col-11 col-lg-4 p-0 mx-2 mb-5">
                    <h5 class="card-title ">Order Details</h5>
                        <div class="card my-4">
                            <ul class="list-group list-group-flush">
                            <!-- some items are only listed if they are existing -->
                                <li class="list-group-item">Ordered by: <?php echo $orderedBy; ?></li>

                                <?php if (isset($deliverTo)&&(strlen($deliverTo)>0)) : ?>
                                <li class="list-group-item">Room No.: <?php echo $deliverTo; ?></li>
                                <?php endif  ?>

                                <?php if (isset($dateDelivered)&&(strlen($dateDelivered)>0)) : ?>
                                <li class="list-group-item">Delivered at: <?php echo $dateDelivered; ?></li>
                                <?php endif  ?>

                                <li class="list-group-item">Subtotal: <?php echo "₱".number_format($totalAmt,2); ?></li>

                                <?php if (isset($promoCode)&&(strlen($promoCode)>0)) : ?>
                                    <?php if ($promoPerCent == '1') : ?>
                                        <li class="list-group-item">Discount: <?php echo $discountVal."% (".$promoCode.")"; ?></li>
                                    <?php else :  ?>
                                        <li class="list-group-item">Discount: <?php echo "₱".number_format($discountVal,2)." (".$promoCode.")"; ?></li>
                                    <?php endif  ?>

                                    <?php
                                        if($totalAmt <= $discountVal){
                                            $discountedAmt = '0.00';
                                        }
                                    ?>

                                    <?php
                                        if ($promoPerCent == 1){
                                            $discountVal = $totalAmt * ($discountVal * 0.01);
                                            $discountedAmt = $totalAmt - $discountVal;
                                        }
                                    ?>
                                    <li class="list-group-item"><h5>Total Amount: <?php echo "₱".number_format($discountedAmt,2); ?></h5></li>
                                <?php else :  ?>
                                    
                                    <li class="list-group-item"><h5>Total Amount: <?php echo "₱".number_format($totalAmt,2); ?></h5></li>
                                <?php endif  ?>
                                
                            </ul>
                        </div>
                    </div>
                    <!-- order summary in card end -->
                    <!-- items table begin -->
                    <div class="col-11 col-lg-7 p-0 mx-auto mx-2">
                    <h5>Purchased Items</h5>
                        <?php foreach ($getOrderDetails as $oD) : ?>
                            <div class="row my-4">
                                <div class="col-12 mx-auto col-sm-4 checkoutImgCol">
                                    <img class="img-thumbnail checkout-item-img my-4" src="<?php echo base_url().'assets/food_menu_images/'.$oD['image']; ?>" alt="">
                                </div>
                                <div class="col-12 col-sm-8 p-0 my-4">
                                    <div class="d-flex bd-highlight col-12 p-0">
                                        <div class="col-6 flex-fill p-2 bd-highlight">
                                            <h6 class="m-0">Menu Item</h6>
                                        </div>
                                        <div class="col-6 flex-fill p-2 bd-highlight p-0">
                                            <?php echo $oD['itemName']; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex bd-highlight col-12 p-0">
                                        <div class="col-6 flex-fill p-2 bd-highlight">
                                            <h6 class="m-0">Quantity</h6>
                                        </div>
                                        <div class="col-6 flex-fill p-2 bd-highlight p-0">
                                            <?php echo $oD['quantity']; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex bd-highlight col-12 p-0">
                                        <div class="col-6 flex-fill p-2 bd-highlight">
                                            <h6 class="m-0">Price</h6>
                                        </div>
                                        <div class="col-6 flex-fill p-2 bd-highlight p-0">
                                            <?php echo "₱".$menuAmt; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach  ?>
                    </div>
                    <!-- items table end -->
                </div>             
            </div>
        </div>  
        