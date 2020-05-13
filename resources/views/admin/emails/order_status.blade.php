<!DOCTYPE html>
<html>
<head>
 <title>Laravel Send Email Example</title>
</head>
<body>

 <h1>Order Status # {{ $order->id}}</h1>
 <p>Dear {{ $order->user->first_name }}</p>
    <span>
Your order has been updated.</span>
<span>Please login to yout user panel of jetonset.com</span>
</body>
</html> 





