<?php

require_once("sparqllib.php");
require_once("encoder.php");
require_once("simple.php");

print "Form sends input: $_POST[query]<br>";

$encoder = new Encoder($_POST['query']);

print "Encoder returns: $encoder->output_vars<br>";
 
$db = sparql_connect("http://lod.cedar-project.nl:8897/sparql/");
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
sparql_ns("d2s", "http://www.data2semantics.org/core/");
sparql_ns("cd", "http://www.data2semantics.org/data/BRT_1889_08_T1_marked/Tabel_1/");
sparql_ns("ns1", "http://www.data2semantics.org/core/Tabel_1/");
sparql_ns("skos", "http://www.w3.org/2004/02/skos/core#");
 
$sparql = "SELECT DISTINCT (str(?age_s) AS ?age_c) (str(?gender_s) AS ?gender_c) (str(?marital_status_s) AS ?marital_status_c) (str(?municipality_s) AS ?municipality_c) (str(?occ_class_s) AS ?occ_class_c) (str(?occ_subclass_s) AS ?occ_subclass_c) (str(?occupation_s) AS ?occupation_c) ?occupation (REPLACE(?position_s, \"^ +| +$\", \"\") AS ?position_c) ?population
FROM <http://lod.cedar-project.nl/resource/BRT_1889_08_T1>
WHERE {
 ?cell d2s:isObservation [ d2s:dimension ?gender ;
                           d2s:dimension ?marital_status ;
                           d2s:dimension ?age ;
			   		         ns1:BENAMING_van_de_onderdeelen_der_onderscheidene_beroepsklassen__met_de_daartoe_behoordende_beroepen ?occupation ;
       						 														       d2s:populationSize ?population ] .
 OPTIONAL {
 ?cell d2s:isObservation [ns1:Positie_in_het_beroep__aangeduid_met_A__B__C_of_D_ ?position] .
 ?position skos:prefLabel ?position_s .
 }

 ?occupation skos:broader ?occ_subclass .
 ?occ_subclass skos:broader ?occ_class .
 ?occ_class skos:broader ?municipality .
 ?municipality skos:prefLabel ?municipality_s .
 ?occ_class skos:prefLabel ?occ_class_s .
 ?occ_subclass skos:prefLabel ?occ_subclass_s .
 ?cell d2s:cell ?cell_s .
 ?age skos:prefLabel ?age_s .
 ?gender skos:prefLabel ?gender_s .
 ?marital_status skos:prefLabel ?marital_status_s .
 ?occupation skos:prefLabel ?occupation_s .

 FILTER (?gender IN (cd:$encoder->output_vars))
 FILTER (?marital_status IN (cd:O, cd:G))
 FILTER (?age IN (cd:12___1878, cd:13___1876, cd:14_---_15__1875___---_1874, cd:16_---_17__1873___---_1872, cd:1878_en_later__beneden_12_j_, cd:18_---_22__1871___---_1867, cd:Geboortejaren___leeftijd_in_j_, cd:25_---_35__1864___---_1854, cd:36_---_50__1853___---_1839, cd:51_---_60__1838___---_1829, cd:61_---_65__1828___---_1824, cd:66_---_70__1823_---_1818, cd:71_en_daarboven__1818_en_vroeger, cd:Van_onbekenden_leeftijd, cd:23_---_24__1866___---_1865))
} ORDER BY (?cell) LIMIT 100";

$result = sparql_query( $sparql ); 
if( !$result ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }
 
$fields = sparql_field_array( $result );
 
print "<p>Number of rows: ".sparql_num_rows( $result )." results.</p>";
print "<table class='example_table'>";
print "<tr>";
foreach( $fields as $field )
{
	print "<th>$field</th>";
}
print "</tr>";
while( $row = sparql_fetch_array( $result ) )
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