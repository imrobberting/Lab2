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
			fopen($file,"c+");//c is create file function in php
		}

		//gets current tally
		$invA = substr($contents[0], 24);
		$invO = substr($contents[1], 25);
		$invB = substr($contents[2], 25);

		$name = $_POST['customer'];
		$oranges = $_POST['oranges'];
		$apples = $_POST['apples'];
		$bananas = $_POST['bananas'];
		$card = $_POST['mode'];

		//simpler implementation, form checking code http://stackoverflow.com/a/14251049
		$fields = array('customer','oranges','apples','bananas','mode');
		$int_fields = array('oranges','apples','bananas');
		$error = false;
		foreach($fields AS $fieldname) {
			if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
					echo "An entry was not filled out. Please check and try again.<br/>" . '<a href="javascript:history.go(-1)">Click here to go back.</a>';
					//javascript:history.go(-1) brings the user back to the former page
					die();
			}
		}

		//checks for negative number and non-numeric input
		foreach($int_fields AS $number) {
			if(!is_numeric($_POST[$number]) || $_POST[$number] < 0) { ?> 
				<p>Non numerical numbers are not a number, unless this is algebra. But we're not working with algebra. Negative fruits are also impossible (we don't do refunds, if that's what you mean). The Laws of Physics simply cannot allow that.</p>
				<p>Have a nice day. <a href="javascript:history.go(-1)">Try again?</a></p>
				<blockquote class="twitter-tweet" lang="en"><p lang="nl" dir="ltr">QA Engineer walks into a bar. Orders a beer. Orders 0 beers. Orders 999999999 beers. Orders a lizard. Orders -1 beers. Orders a sfdeljknesv.</p>&mdash; Bill Sempf (@sempf) <a href="https://twitter.com/sempf/status/514473420277694465">September 23, 2014</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
				<?php die();
			}
		}

		//updates tally
		$invA = $invA + $apples;
		$invO = $invO + $oranges;
		$invB = $invB + $bananas;

		//computes cost
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
			die();
		}
		if (flock($fupdate, LOCK_EX)) {
			fwrite($fupdate, "Total number of apples: ".$invA."\r\n");
			fwrite($fupdate, "Total number of oranges: ".$invO."\r\n");
			fwrite($fupdate, "Total number of bananas: ".$invB."\r\n");
			flock($fupdate, LOCK_UN);
		} else {
			echo "Couldn't get the lock!";
			die();
		}
		fclose($fupdate);
?>
