<?php

require_once("dataAccess.php");
require_once("decoder.php");
require_once("rewritingRules.php");

print "Form sends input: $_POST[query]<br>";

$decoder = new Decoder($_POST['query']);

print "Decoder returns: ";
var_dump($decoder->output_params);

$rules = RewritingRules::instance();

$dataaccess = new DataAccess();
$dataaccess->executeQuery($rules->getValue($decoder->output_params[0]));
 
$fields = $dataaccess->getResultFields();
 
print "<p>Number of rows: ".$dataaccess->getResultNumRows()." results.</p>";
print "<table class='example_table'>";
print "<tr>";
foreach( $fields as $field )
{
	print "<th>$field</th>";
}
print "</tr>";
while( $row = $dataaccess->getResultArray() )
{
	print "<tr>";
	foreach( $fields as $field )
	{
		print "<td>$row[$field]</td>";
		}
		print "</tr>";
}
print "</table>";



?>