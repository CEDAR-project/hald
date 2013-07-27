<?php

require_once("dataAccess.php");
require_once("decoder.php");
require_once("rewritingRules.php");
require_once("aggregator.php");

print "Form sends input: $_POST[query]<br>";

$decoder = new Decoder($_POST['query']);

print "Decoder returns params: ";
var_dump($decoder->output_params);
print "<br>";
print "Decoder returns target: ";
var_dump($decoder->target);
print "<br>";

$rules = RewritingRules::instance();

$dataaccess = new DataAccess();
$dataaccess->executeQuery($rules->getValue($decoder->output_params), $decoder->target);

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

//$aggregator = new Aggregator();
//print $aggregator->getAggregate($dataaccess->getResultArray());



?>