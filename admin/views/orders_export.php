<?php
$options["endline"] = $_GET["endline"];
$options["delimiter"] = $_GET["delimiter"];
$options["enclose"] = $_GET["enclose"];
$options["decimal"] = $_GET["decimal"];
$options["turnover"] = $_GET["turnover"];
$options["debtors"] = $_GET["debtors"];
$options["vat"] = $_GET["vat"];
$options["vatcode"] = $_GET["vatcode"];

$csv_file = $this->generate_csv($_GET["status"], $_GET["date_from"], $_GET["date_to"], $options);
?>
<a href="<?php echo $csv_file; ?>">Download export here</a>