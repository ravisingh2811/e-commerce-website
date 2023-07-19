
<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75">
        <h1 class="font-baloo font-size-20">Summary of Shopping</h1>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-9">
               <h3>Name: <?php echo $_SESSION['name'] ?></h3>
               <h3>phone: <?php echo $_SESSION['phone'] ?></h3>
               <h3>price: <?php echo $_SESSION['price'] ?></h3>
               <h3>Delivery address: <?php echo  $_SESSION['address'] ?></h3>
        
            </div>
        </div>
        <!--  !shopping cart items   -->
    </div>
</section>





<button style=" font-size: 24px; background-color: #4CAF50; border-radius: 8px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);" id="rzp-button1">Pay Now</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<form name='razorpayform' action="verify.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<script>
// Checkout details as a json
var options = <?php echo $json?>;

/**
 * The entire list of Checkout fields is available at
 * https://docs.razorpay.com/docs/checkout-form#checkout-fields
 */
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    document.razorpayform.submit();
};

// Boolean whether to show image inside a white frame. (default: true)
options.theme.image_padding = false;

options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    // Boolean indicating whether pressing escape key 
    // should close the checkout form. (default: true)
    escape: true,
    // Boolean indicating whether clicking translucent blank
    // space outside checkout form should close the form. (default: false)
    backdropclose: false
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>