<script>
$(document).ready(function(){
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
                    // Read values

                    var discount = msg[0].amount;
                    $('#discount').text("₱ " + discount);
                    $('#inDiscount').text(discount);
                    
                    var subtotal = parseFloat($('#subtotal').val());
                    discount = parseFloat(discount);
                    
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
                    subtotal = subtotal.toFixed(2).replace(/[^\d.]/g, "")
                                 .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
                                 .replace(/\.(\d{2})\d+/, '.$1')
                                 .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                    $('#total').text("₱ " + subtotal);
                    $('#promo_code').val('');

                     alert('invalid code');
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
