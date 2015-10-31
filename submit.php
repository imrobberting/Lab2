<!DOCTYPE html>
<?php
		$file = 'order.txt';
		
//fix from http://php.net/manual/en/function.fgets.php#92397
	if(file_exists($file)){
		if($fhandle = fopen($file,"r")){
		//tests if at EOF, break if at EOF
			while (!feof($fhandle)){
				$contents[] = fgets($fhandle);
				}
			fclose($fhandle);
			}
		} else {
			// this is weird
			fopen($file,"c+");
			fclose($file);
		}

		$invA = substr($contents[0], 24);
		$invO = substr($contents[1], 25);
		$invB = substr($contents[2], 25);

		$oranges = $_POST['oranges'];
		$apples = $_POST['apples'];
		$bananas = $_POST['bananas'];

		$invA = $invA + $apples;
		$invO = $invO + $oranges;
		$invB = $invB + $bananas;

		$O = $oranges*.59;
		$totalO = number_format($O, 2);
		$A = $apples*.69;
		$totalA = number_format($A, 2);
		$B = $bananas*.39;
		$totalB = number_format($B, 2);

		$x = $totalO + $totalA + $totalB;
		$total = number_format($x, 2);
?>
<html>
	<head>
		<title>Receipt</title>
	</head>
<body>
	<h1>Order Receipt</h1>
	&nbsp;
	<p>Name: <?php print $_POST['customer']; ?></p>
	&nbsp;
	<table border = "border">
		<tr>
			<th> Item </th>
			<th> Quantity </th>
			<th> Unit Price (SGD) </th>
			<th> Amount (SGD) </th>
		</tr>
		<tr>
			<td> Apple(s) </td>
			<td> <?php print $_POST['apples']; ?> </td>
			<td> 0.69 </td>
			<td> <?php print $totalA; ?> </td>
		</tr>
		<tr>
			<td> Orange(s) </td>
			<td> <?php print $_POST['oranges']; ?> </td>
			<td> 0.59 </td>
			<td> <?php print $totalO; ?> </td>
		</tr>
		<tr>
			<td> Banana(s) </td>
			<td> <?php print $_POST['bananas']; ?> </td>
			<td> 0.39 </td>
			<td> <?php print $totalB; ?> </td>
		</tr>
		<tr>
			<td colspan="4"> Total Payment (SGD): <?php print $total; ?> </td>
		</tr>
		<tr>
			<td colspan="4"> Mode of Payment: <?php print $_POST['mode']; ?> </td>
		</tr>
	</table>
	&nbsp;
	<a href="../Lab2/index.htm">Back to Order Form</a>
</body>
</html>
<?php
/*
http://php.net/manual/en/function.ftruncate.php#104455
> "If you want to empty a file of it's contents bare in mind that opening a file in w mode truncates the file automatically"
*/
	if (file_exists($file)) {
		$fupdate = fopen("./order.txt", "c");
		} else {
			echo "File does not exist";
		}
		if (flock($fupdate, LOCK_EX)) {
			fwrite($fupdate, "Total number of apples: ".$invA."\r\n");
			fwrite($fupdate, "Total number of oranges: ".$invO."\r\n");
			fwrite($fupdate, "Total number of bananas: ".$invB."\r\n");
			flock($fupdate, LOCK_UN);
		} else {
			echo "Couldn't get the lock!";
		}
		fclose($fupdate);
?>

