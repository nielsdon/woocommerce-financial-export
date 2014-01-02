<?php
$options["endline"] = $_GET["endline"];
$options["delimiter"] = $_GET["delimiter"];
$options["enclose"] = $_GET["enclose"];
$csv_file = $this->generate_csv($_GET["status"], $_GET["date_from"], $_GET["date_to"], $options);
?>
<a href="<?php echo $csv_file; ?>">Download export here</a>