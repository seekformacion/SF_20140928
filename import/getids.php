<?php

global $v;


include('db.php');
include('dbfuncs.php');

$v['conf']['host'] = "184.173.247.226";
$v['conf']['db'] = "laiislac_bd";
$v['conf']['usr'] = "laiislac";
$v['conf']['pass'] = "ideosites2009";
$v['debug'] = 0;

set_time_limit(0);
ini_set("memory_limit", "-1");

print_r($argv);

$ids = $argv[1];


$dat = DBselect("SELECT count(*) as C from status;");
$c = $dat[1]['C'];
$dat = DBselect("SELECT lastpos from status where server=$ids;");
$lp = $dat[1]['lastpos'];

$fp = $lp + 500;


$client = new SoapClient("http://www.marinespecies.org/aphia.php?p=soap&wsdl=1");
while ($lp <= $fp) {

    $mod = ($lp % $c);
    if ($mod == ($ids - 1)) {

        $taxon = $client->getAphiaRecordByID($lp);
        if (isset($taxon)) {
            if (($taxon->status == 'accepted') && ($taxon->AphiaID == $taxon->valid_AphiaID) && (!$taxon->isExtinct)) {
                DBUpIns("INSERT INTO valids (id) VALUES ($lp);");
                DBUpIns("UPDATE status SET lastpos=$lp WHERE server=$ids;");
            }
        }


    }
    $lp++;
}
DBUpIns("UPDATE status SET lastpos=$lp WHERE server=$ids;");




?>