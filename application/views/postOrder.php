        <div class="container-fluid postOrderContainer"
        style='background:url("<?php echo base_url()."assets/images/thankyoubg - Copy.jpg";?>"); height: 600px;
        background-position: center; background-repeat: no-repeat; background-size: cover; position: relative;'>
            <div class="col-lg-8 col-md-10 col-sm-11 col-11 m-1 p-5 mx-auto" style='position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background-color:white;border-radius:25px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
            <!-- insert reference number below -->
                <h2>Thank you for your order!</h2>
                <h6 style="display:inline;">Order Reference No: </h6>
                <h2 style="display:inline;"><span class="badge badge-primary"><?php echo $_SESSION['refNo']; ?></span></h2>
                <hr>
                <p>Your order has been placed. You may visit our <a href="<?php echo $_SESSION['qr'] ?>">home page</a> to track your order using your <b>order reference number</b>.</p>
                <p>Cancelling your order? please contact our staff by dialling "0" from our provided telephone.</p>
            </div>
        </div>
        <!-- comment from local latest -->
        