<script>
$(document).ready(function(){

    <?php foreach ($getCart as $gct): ?>
        var menuInput = document.getElementById("inputQty-" + "<?php echo $gct['menu_id'];?>");
        var menuIdInput = document.getElementById("menu_id-" + "<?php echo $gct['menu_id'];?>");
        <?php if($_SESSION['token'] == $gct['token']): ?>
            
            if(typeof(menuInput) != "undefined" && menuInput !== null) {
                $(menuInput).change(function(){
                    var qty = $(menuInput).val();
                    var menu_id = $(menuIdInput).val();
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
                    var validFrom = Date.parse(msg[0].valid_from);
                    var validTo = Date.parse(msg[0].valid_to);
                    var today = new Date();
                    today = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    today = Date.parse(today);
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

                    if (validFrom <= today && validTo >= today && branchValid && msg[0].status == 1){
                        //if valid, set value to discount
                        if (msg[0].percent == 0){
                            discount = parseFloat(msg[0].amount);
                        }else{
                            discount = parseFloat(subtotal * (msg[0].amount * 0.01));
                        } 
                    }else{
                        // invalid promo code
                    $("#promo_code_div").css({"border": "solid 2px red"});
                    }
                    
                    $('#discount').text("₱ " + discount.toFixed(2));
                    $('#inDiscount').text(discount.toFixed(2));
                    
                    discount = parseFloat(discount.toFixed(2));
                    
                    var total_amt;
                    if(total_amt <= discount){
                        total_amt = 0.00;
                    }

                    total_amt = subtotal - discount;

                    total_amt = total_amt.toFixed(2).replace(/[^\d.]/g, "")
                                 .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                                 .replace(/\.(\d{2})\d+/, '.$1')
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    $('#total').text("₱ " + total_amt);


                }else{
                    var subtotal = $('#subtotal').val();

                    $('#total').text("₱ " + subtotal);
                    $('#promo_code').val('');
                    $("#promo_code_div").css({"border": "solid 2px red"});
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
