<form>
	<input type="hidden" name="page" value="<?php echo $this->plugin_slug ?>"/>
	<p>Choose order status</p>
	<?php foreach($this->get_order_statuses() as $order_status) { 
		echo "<input type=\"radio\" name=\"status\" value=\"$order_status\"/> $order_status<br/>\n";
	}?>
<input type="submit" value="Export"/>
</form>