<?php
//set default order status
if($_GET["status"]) { $def_status = $_GET["status"]; } else { $def_status = "completed"; }
//set default dates
if($_GET["date_from"]) { $date_from = $_GET["date_from"]; } else { $date_from = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y"))); }
if($_GET["date_to"]) { $date_to = $_GET["date_to"]; } else { $date_to = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y"))); }

//init the datepicker
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<form>
	<input type="hidden" name="page" value="<?php echo $this->plugin_slug ?>"/>
<table>
	<tr><td>Choose order status</td>
	<td><select name="status">
	<?php foreach($this->get_order_statuses() as $order_status) { 
		echo "<option value=\"$order_status\"";
		if($def_status==$order_status) { echo " selected=\"true\""; }
		echo "/> $order_status</option>\n";
	}?>
	</select></td></tr>
	<tr><td>From date</td>
	<td><input id="date_from" type="text" class="MyDate" name="date_from" value=""/></td></tr>
	<tr><td>To date</td>
	<td><input id="date_to" type="text" class="MyDate" name="date_to" value=""/></td></tr>
</table>

<script type="text/javascript">

jQuery(document).ready(function() {
    jQuery('.MyDate').datepicker({
        dateFormat : 'yy-mm-dd',
        buttonText : 'Choose',
        showOn : "both",
        showButtonPanel : true
    });
    jQuery('input[name="date_from"]').val('<?php echo $date_from ?>');
    jQuery('input[name="date_to"]').val('<?php echo $date_to ?>');
});

</script>
<input type="submit" value="Export"/>
</form>
<hr/>