<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />    
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Online Order</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />    
</head>
<body style="background: #eee;">
	<div style="background: #fff; border-top: 1px solid; margin: 0 auto 80px;width: 600px; ">
		<div style="margin-left: -15px;margin-right: -15px; overflow: hidden;">
			<div ></div>
			<div style="">
				<table class="table" id="orders">
		            <tr>
		              <th>#</th>
		              <th>Item Name</th>
		              <th>Item Price</th>
		              <th>Qty</th>
		              <th>Price</th>
		            </tr>

		            <?php
		            $total_price = 0;
		            $s = 1;
		            ?>

		            @foreach($orders as $order)
		            <tr>
		              <td>{{$s}}</td>
		              <td>{{$order->item_name}}</td>
		              <td>{{$order->item_price}}</td>
		              <td>{{$order->item_qty}}</td>
		              <td>{{number_format($order->item_qty*$order->item_price, 2)}}</td>
		            </tr>
		            <?php
		            $total_price += number_format($order->item_qty*$order->item_price, 2);
		            $s++;
		            ?>
		            @endforeach
		            <tr>
		              <th colspan="3" style="text-align:right">Total Price = </th>
		              <th colspan="2">{{number_format($total_price, 2)}}</th>
		            </tr>
		          </table>
			</div>
		</div>
	</div>

</body>
</html>