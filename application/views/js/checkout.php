<script>
$(document).ready(function(){

    <?php foreach ($getCart as $gct): ?>
        var menuInput = document.getElementById("inputQty-" + "<?php echo $gct['menu_id'];?>");
        var menuIdInput = document.getElementById("menu_id-" + "<?php echo $gct['menu_id'];?>");
        <?php if($_SESSION['token'] == $gct['token']): ?>
            
            if(typeof(menuInput) != "undefined" && menuInput !== null) {
                $(menuInput).focusout(function(){
                    
                    var qty = $("#inputQty-" + "<?php echo $gct['menu_id'];?>").val();
                    var menu_id = $("#menu_id-" + "<?php echo $gct['menu_id'];?>").val();
                    
                    $.ajax({
                        url:"<?php echo base_url(); ?>update_Bag_Item",
                        method:"POST",
                        dataType:'JSON',
                        data:{inputQty:qty,
                        menuid:menu_id}
                    });
                    location.reload();
                    return false;
                });
            }
        <?php endif; ?>
    <?php endforeach; ?>  
    
    $('#promo_code').focusout(function(){

        $('.apply_promo').click();
    });

    $('.apply_promo').click(function(){
        var promoCode = $('#promo_code').val();

        $.ajax({
            url:"<?php echo base_url(); ?>check_promo",
            method:"POST",
            dataType:'JSON',
            data:{promoCode:promoCode},
            success: function(msg) {

                var len = msg.length;
                $('#discount').text('');
                if(len > 0){

                    //check validity
                    //var validFrom = new Date(msg[0].valid_from);
                    // var validTo = new Date(msg[0].valid_to);
                    var f = new Date(msg[0].valid_from);
                    f.setHours(0,0,0);
                    var validFrom = f;

                    var e = new Date(msg[0].valid_to);
                    e.setHours(11,59,0);
                    var validTo = e;

                    var d = new Date();
                    d.setHours(8,0,0);
                    var today = d;

                    var validFroms = new Date(msg[0].valid_from).toDateString();
                    var validTos = new Date(msg[0].valid_to).toDateString();
                    var todays = new Date().toDateString();

                    // Read values
                    
                    var discount = 0;
                    var subtotal = parseFloat($('#subtotal').val());

                    var branchValid = false;
                    var branchesArr = msg[0].branch_id.split(',');
                    for(i = 0; i <= branchesArr.length-2; i++){
                        if (branchesArr[i] == <?php echo $_SESSION['selectedBranch'];?>){
                            branchValid = true;
                        }
                    }
                    
                        // alert("validFrom: " + validFrom);
                        // alert("today: " + today);
                        // alert("validTo: " + validTo);
                    if (today >= validFrom && today <= validTo){
                        
                        if(branchValid == true){
                           
                            if(msg[0].status == 1){
                            
                                // hide error if valid
                                $("#promo_code_div").css({"border": "none"});

                                //if valid, set value to discount
                                
                                $(".promoCodeError").text("");
                                if (msg[0].percent == 0){
                                    discount = parseFloat(msg[0].amount);
                                    $('#discount').text("₱ " + discount.toFixed(2));
                                }else{
                                    discount = parseFloat(subtotal * (msg[0].amount * 0.01));
                                    $('#discount').text(msg[0].amount + "%");

                                } 
                                
                                //discount = parseFloat(discount.toFixed(2));
                                
                                var total_amt;
                                
                                total_amt = subtotal - discount;
                                if(total_amt <= discount){
                                    total_amt = 0.00;
                                }

                                total_amt = total_amt.toFixed(2).replace(/[^\d.]/g, "")
                                 .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                                 .replace(/\.(\d{2})\d+/, '.$1')
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                                $('#total').text("₱ " + total_amt);

                            }else{
                                $(".promoCodeError").text("The promo code you have entered is deactivated.");
                                $('#promo_code').val('');
                                $(".promoCodeError").css({"color": "red"})
                            } 
                        }else{
                            $(".promoCodeError").text("The promo code you have entered is not applicable at this branch.");
                            $('#promo_code').val('');
                            $(".promoCodeError").css({"color": "red"})
                        }
                    }else{
                        // invalid promo code

                        $(".promoCodeError").text("The promo code you have entered is expired.");
                        $('#promo_code').val('');
                        $(".promoCodeError").css({"color": "red"})
                    }


                }else{
                    var subtotal = $('#subtotal').val();

                    subtotal = parseFloat(subtotal).toFixed(2).replace(/[^\d.]/g, "")
                                 .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                                 .replace(/\.(\d{2})\d+/, '.$1')
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    $('#total').text("₱ " + subtotal);
                    $('#promo_code').val('');
                    // $("#promo_code_div").css({"border": "solid 2px red"});
                    $(".promoCodeError").text("The promo code you have entered is invalid.");
                    $(".promoCodeError").css({"color": "red"})
                    $('#promo_code').val('');
                }

            }
        });
        return false;
    });
});


        $('#checkedIn').change(function() {
            if(this.checked) {
                $( "#roomNumber" ).prop( "readonly", false);
            }else{
                $( "#roomNumber" ).prop( "readonly", true);
                $( "#roomNumber" ).val("");
            }

    });
</script>
