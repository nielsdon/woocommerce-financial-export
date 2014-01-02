<?php
$csv_file = $this->generate_csv($_GET["status"], $_GET["date_from"], $_GET["date_to"]);
?>
<a href="<?php echo $csv_file; ?>">Download export here</a>