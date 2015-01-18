<?php
$inc_dir = '../../include/';
require_once $inc_dir.'basic.php';
require_once("config.php");
require_once("parser.class.php");

$expected = array( 'username' => $settings['WEB_UI_USER'], 'password' => $settings['WEB_UI_PASSWORD']);
$supplied = (isset($_POST['username']) && isset($_POST['username']) )
                ? array( 'username' => $_POST['username'], 'password' => $_POST['password'])
                : array( 'username' => '', 'password' => '');
$_auth->authenticate( $expected, $supplied );
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="robots" content="NOINDEX,NOFOLLOW">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>phpdhcpd</title>
  <script type="text/javascript">
		function sortby (to, p) {
			var myForm = document.createElement("form");
			myForm.method = "post";
			myForm.action = to;
			for (var k in p) {
				var myInput = document.createElement("input");
				myInput.setAttribute("name", k);
				myInput.setAttribute("value", p[k]);
				myForm.appendChild(myInput);
			}
			document.body.appendChild(myForm);
			myForm.submit() ;
			document.body.removeChild(myForm);
		}
  </script>
</head>
<body>

  <div>
    <h2>DHCP Daemon IP-Address Leases</h2>
    <p>This page lists the contents of your lease file.<br>
      It will not show any hosts with static/fixed IPs, even if they where assigned by the server.</p>
  </div>

<?php
//read leases file
if (isset($_POST['searchfilter'])) {
	$searchfilter = $_POST['searchfilter'];
} else {
	$searchfilter = "";
}
if (isset($_POST['sort_column'])) {
	$sort_column = $_POST['sort_column'];
} else {
	$sort_column = 0;
}
if (isset($_POST['onlyactiveleases'])) {
	$onlyactiveleases = true;
} else {
	$onlyactiveleases = false;
}

if (file_exists($dhcpd_leases_file) && is_readable($dhcpd_leases_file))
{
	$open_file = fopen($dhcpd_leases_file, "r") or die("Unable to open DHCP leases file.");
	if ($open_file)
	{
		if ($searchfilter != "") {
			$searchfiledmsg = $searchfilter;
		} else {
			$searchfiledmsg = "Type to search";
		}

		//Call the dhcplease file parser
		$parser = new ParseClass();
		$parser->parser($open_file);

		?>

		<form action = "index.php"  accept-charset="UTF-8" method="post" id="search-form">
		<input type="checkbox" name="onlyactiveleases" value="true"
		<?php
		if ($onlyactiveleases){ echo "checked='true'"; }
		?>
		/> Only display active leases</br>
		Search Filter:
		<input type="text" maxlength="255" name="searchfilter" id="searchfilter" size="20" placeholder="Enter Search"
		<?php
			echo " value = '" . $searchfilter . "'>";
		?>
		<input type="submit" name="Search" value="Search">

		<?php
		if ($searchfilter != ""){ echo "<a href='index.php'>Clear Search</a>\n"; }
		?>

		</form>
		<br><br>

		<table>
		<tr class="table_title">
		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-1',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			IP Address
			<a href="javascript:sortby('index.php',{sort_column:'1',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>

		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-2',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			Start Time
			<a href="javascript:sortby('index.php',{sort_column:'2',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>

		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-3',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			End Time
			<a href="javascript:sortby('index.php',{sort_column:'3',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>

		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-4',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			Lease Expires
			<a href="javascript:sortby('index.php',{sort_column:'4',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>

		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-5',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			MAC Address
			<a href="javascript:sortby('index.php',{sort_column:'5',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>
		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-6',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			Client Identifier
			<a href="javascript:sortby('index.php',{sort_column:'6',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>
		<td width="14%"><b>
			<a href="javascript:sortby('index.php',{sort_column:'-7',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_down.png" alt="Sort Descending" title="Sort Descending">
			</a>
			Hostname
			<a href="javascript:sortby('index.php',{sort_column:'7',searchfilter:'<?php echo $searchfilter;?>'})">
				<img src="images/arrow_up.png" alt="Sort Ascending" title="Sort Ascending">
			</a>
		</b></td>

		</tr>
		<?php
		//Display the dhcp lease table using the filter and ordered
		$parser->print_table($searchfilter, $sort_column, $onlyactiveleases);
		fclose($open_file);
		?>
		</table>
		<?php
		echo "<p>Total number of entries in DHCP lease table: " . count($parser->dhcptable) . "</p>\n";
		echo "<p>Number of entries displayed on this page: " . $parser->filtered_number_display . "</p>\n";
	}
}
else
{
	echo "<p class='error'>The DHCP leases file does not exist or does not have sufficient read privileges.</p>";
}

?>

  <div class="phpdhcpd_footer">
    Powered by <a href="https://github.com/firefly2442/phpdhcpd/">phpdhcpd</a>
  </div>
</body>
</html>