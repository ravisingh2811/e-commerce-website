<?php
$server = 'localhost';
$database = 'eweb';
$user = 'root';
$pass = '';

$con = mysqli_connect($server,$user,$pass, $database);
 if (!$con){
     echo "Fail " . mysqli_connect_error();
 }
?>

<?php

require('config.php');

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $orderid = $_SESSION['razorpay_order_id'];
    $paymentid = $_POST['razorpay_payment_id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $address = $_SESSION['address'];
    $date = date('d-m-y h-i-s');
   $query = "INSERT INTO `order_details`(`name`, `email`, `phone`, `address`, `orderid`, `paymentid`, `date`) 
   VALUES ('$name' , '$email' , '$phone' , '$address' , '$orderid' , '$paymentid' , '$date' )";
if(mysqli_query($con , $query)){
    $qu = "DELETE FROM cart WHERE user_id = '1'";
    mysqli_query($con , $qu );
    header('Location: http://localhost/ecom/sucess.html ');
}else{
    echo mysqli_errno($con);
}
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
