<?php
//=====================================================================================
// Tradotto in Italiano da Bernardeschi Riccardo
//	ricca82it@gmail.com
// Last Seen Module 1.1
// Created for Joomla! 1.x by Admir Bahtagic (Ado_k2)
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//=====================================================================================
defined( '_VALID_MOS' ) or die( 'Accesso diretto a questa locazione non consentito.' );
global $mosConfig_offset;

$count = @$params->count ? intval( $params->count ) : 10;
$query = "SELECT id, username, name, lastvisitDate"
	. "\nFROM #__users"
	. "\nWHERE block='0' and lastvisitDate<>'0000-00-00 00:00:00'"
	. "\nORDER BY lastvisitDate  DESC LIMIT $count";
$database->setQuery( $query );
$rows = $database->loadObjectList();	

function seg2tiempo($segundos){ 
   $tiempo = $segundos; 
    $tiempo = abs($tiempo); 
    $dias = floor($tiempo/86400); 
    $resto_dias = $tiempo % 86400; 
    $horas = floor($resto_dias/3600); 
    $resto_horas = $resto_dias % 3600; 
    $minutos = floor($resto_horas/60); 
    $resto_minutos = $resto_horas % 60; 
    $segundos = floor($resto_minutos); 
	
if($dias==0){ 
$dias="" ;
}elseif($dias==1){
$dias="$dias giorno "; 
}else
{
$dias="$dias giorni ";
}

if($horas==0){ 
$horas="" ;
}elseif($horas==1){
$horas="$horas ora "; 
}else
{
$horas="$horas ore ";
}

if($minutos==0){ 
$minutos="" ;
}else{
$minutos="$minutos min ";
}

if($segundos==0){ 
$segundos="0" ;
}else{
$segundos="$segundos sec ";
}


return $dias.$horas.$minutos.$segundos."fa"; 
} 

?> 

<table cellpadding="1" cellspacing="1" border="0">
<?php foreach ($rows as $row) { 

$f1 = $row->lastvisitDate;
$f2 = date("Y-m-d H:i:s");
$dif = strtotime($f2)-strtotime($f1);

?>
	<tr>
		<td><b>&raquo; &nbsp;<?php echo $row->username ?></b><br><span="smalldark"><?php echo seg2tiempo($dif); ?></span></td>
	</tr>
<?php
}
?>
</table>

