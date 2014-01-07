<?php
//set default order status
if($_GET["status"]) { $def_status = $_GET["status"]; } else { $def_status = "completed"; }
//set default dates
if($_GET["date_from"]) { $date_from = $_GET["date_from"]; } else { $date_from = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1, date("Y"))); }
if($_GET["date_to"]) { $date_to = $_GET["date_to"]; } else { $date_to = date("Y-m-d", mktime(0, 0, 0, date("m"), 0, date("Y"))); }

//set default CSV options
if($_GET["endline"]) { $endline = $_GET["endline"]; } else { $endline = "windows"; }
if($_GET["delimiter"]) { $delimiter = $_GET["delimiter"]; } else { $delimiter = "comma"; }
if($_GET["enclose"]) { $enclose = $_GET["enclose"]; } else { $enclose = "double"; }

//set default formatting options
if($_GET["decimal"]) { $decimal = $_GET["decimal"]; } else { $decimal = "comma"; }

//set default ledget options
if($_GET["turnover"]) { $turnover = $_GET["turnover"]; } else { $turnover = "8000"; }
if($_GET["debtors"]) { $debtors = $_GET["debtors"]; } else { $debtors = "1300"; }
if($_GET["vat"]) { $vat = $_GET["vat"]; } else { $vat = "1000"; }
if($_GET["vatcode"]) { $vatcode = $_GET["vatcode"]; } else { $vatcode = "VH"; }

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
	<tr><td><strong>CSV Options</strong></td></tr>
	<tr><td>Endline:</td><td><input type="radio" name="endline" value="windows"<?php if($endline=="windows"){ echo " checked=\"true\""; } ?>/>&#92;r&#92;n (windows)<br/>
		<input type="radio" name="endline" value="mac"<?php if($endline=="mac"){ echo " checked=\"true\""; } ?>/>&#92;r (mac)<br/>
		<input type="radio" name="endline" value="unix"<?php if($endline=="unix"){ echo " checked=\"true\""; } ?>/>&#92;n (linux/unix)<br/>
	</td></tr>
	<tr><td>Field delimiter:</td><td><input type="radio" name="delimiter" value="comma"<?php if($delimiter=="comma"){ echo " checked=\"true\""; } ?>/>Comma (,)<br/>
		<input type="radio" name="delimiter" value="semicolon"<?php if($delimiter=="semicolon"){ echo " checked=\"true\""; } ?>/>Semicolon (;)<br/>
		<input type="radio" name="delimiter" value="tab"<?php if($delimiter=="tab"){ echo " checked=\"true\""; } ?>/>Tab (	)</td></tr>
	<tr><td>Field enclose:</td><td><input type="radio" name="enclose" value="single"<?php if($enclose=="single"){ echo " checked=\"true\""; } ?>/>Single quotes (')<br/>
		<input type="radio" name="enclose" value="double"<?php if($enclose=="double"){ echo " checked=\"true\""; } ?>/>Double quotes (")<br/>
		<input type="radio" name="enclose" value="none"<?php if($enclose=="none"){ echo " checked=\"true\""; } ?>/>None</td></tr>
	
	<tr><td><strong>Formatting Options</strong></td></tr>
	<tr><td>Decimal separation:</td><td><input type="radio" name="decimal" value="period"<?php if($decimal=="period"){ echo " checked=\"true\""; } ?>/>Period (.)<br/>
	<input type="radio" name="decimal" value="comma"<?php if($decimal=="comma"){ echo " checked=\"true\""; } ?>/>Comma (,)<br/>
	</td></tr>
	
	<tr><td><strong>Ledger Options</strong></td></tr>
	<tr><td>Ledger number turnover (credit):</td><td><input id="turnover" type="text" name="turnover" value="<?php echo $turnover; ?>"/></td></tr>
	<tr><td>Ledger number debtors (debit):</td><td><input id="debtors" type="text" name="debtors" value="<?php echo $debtors; ?>"/></td></tr>
	<tr><td>Ledger number VAT (debit):</td><td><input id="vat" type="text" name="vat" value="<?php echo $vat; ?>"/></td></tr>
	<tr><td>VAT code:</td><td><input id="vatcode" type="text" name="vatcode" value="<?php echo $vatcode; ?>"/></td></tr>
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
<input type="submit" value="Generate CSV"/>
</form>
<hr/>