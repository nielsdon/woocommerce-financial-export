<?php
$orders = $this->get_orders_by_status($_GET["status"]);
?>
<a href="<?php echo $this->generate_csv($orders); ?>">Download export here</a>
<?php
echo "<table><thead><tr><td>ID</td><td>Date</td><td>First name</td><td>Last name</td><td>Address</td><td>Postal</td><td>City</td><td>Total</td><td>Tax</td></tr></thead>\n";
echo "<tbody>\n";
foreach ($orders as $order) {
	echo "<tr>";
	echo "<td>" . $order["ID"] . "</td>";
	echo "<td>" . $order["order_date"] . "</td>";
	echo "<td>" . $order["first_name"] . "</td>";
	echo "<td>" . $order["last_name"] . "</td>";
	echo "<td>" . $order["address"] . "</td>";
	echo "<td>" . $order["postal_code"] . "</td>";
	echo "<td>" . $order["city"] . "</td>";
	echo "<td>" . $order["order_total"] . "</td>";
	echo "<td>" . $order["tax"] . "</td>";
	echo "</tr>\n";
}
echo "</tbody>\n</table>";