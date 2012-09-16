<?php


/////////////////////////////////////////////////////////
//// qua ho riscritto al minimo indispensabile le funzioni x far funzionare la pagina delle statistiche
//// in attesa che funzioni.php riapra i battenti.

include "setup.php";
include "skin/$skinPreferita/theme.php";
include "tmp_funzioncine.php";
include "header.php";


//phpinfo(); 
//$ISPAL =true;





//////////////////////////////////////////
////// pagina vera e propria.

?>
<table width="<?=$CONSTLARGEZZA600?>" border="1">
 <tr>
  <td width="30%" valign=top>
   <h1>Utenti</h1>
   <h3>Iscritti ieri o oggi</h3>
<?

$rs2=query("select m_snome as _fotoutente,l.m_snome as nome,m_dataiscrizione,(now()-m_dataiscrizione)/86400 as oraMenoAllora,provincia from loginz l where ((now()-m_dataiscrizione) >= 86400000000 ) order by m_dataiscrizione desc");
//$rs2=getRecordSetByQuery("select m_snome as _fotoutente,l.m_snome as nome,m_dataiscrizione,provincia from loginz l where (m_dataiscrizione >= date()-1) ");
scriviRecordSetConTimeout($rs2,10);
?>




  <h3>Gli ultimi collegati</h3>
<?



$rs2=getRecordSetByQuery(
	$ISPAL ?
		"select m_snome as _fotoutente,m_snome as nome,m_bGuest as _guest,provincia,m_datalastcollegato as _data_alle,m_bserio as _serio,m_bsingle as _single FROM loginz order by (m_datalastcollegato) DESC"
	:
		"select m_snome as _fotoutente,m_snome as nome,m_bGuest as _guest,m_datalastcollegato as _data_alle,m_bserio as _serio,m_bsingle as _single FROM loginz order by (m_datalastcollegato) DESC"

	);



scriviRecordSetConTimeout($rs2,10);

?>

  <h3>Quelli che han scritto più messaggi ultimamente</h3>
<?

$rs2 = getRecordSetByQuery("SELECT l.m_snome as _fotoutente,l.m_snome as nome,count(*) as quanti  FROM messaggi m,loginz l where l.id_login=m.id_login  group by m.id_login,l.m_snome order by count(*) desc");

scriviRecordSetConTimeout($rs2,10);
?>


   <h3>I più vicini alla caffettiera :)</h3>
<?
$rs=getRecordSetByQuery("select m_snome as _fotoutente,m_snome as nome,m_npx from loginz order by (m_npx) deSC");
scriviRecordSetConTimeout($rs,10);
?>

 
   <h3>Ultimi 30 Entrati negi ultimi 2 giorni</h3>

<?
$rs2=getRecordSetByQuery("select m_snome,m_datalastcollegato from loginz where m_datalastcollegato < date()+1 AND m_datalastcollegato >= date()-2 order by m_datalastcollegato desc");
scriviRecordSetConTimeout($rs2,30);

echo "asdkhkj";
?>


  </td>

  <td width="30%" valign=top>



<?
/*
//   <h1>Utenti</h1>
//	<h3>Quelli della mia città (ordinati x ultimo collegamento)</h3>

$rs2=getRecordSetByQuery("select m_snome as _fotoutente,m_snome as nome,provincia FROM loginz WHERE provincia LIKE '"
	+$_SESSION["provincia"]+"' order by (m_datalastcollegato) DESC");

scriviRecordSetConTimeout($rs2,20);
*/
?>



   <h1>Ordini</h1>
 <h3>Quanti ce n'è</h3>
<?
$rs=getRecordSetByQuery("select count(*) as quanti from ordini o");

scriviRecordSetConTimeout($rs,10);
?>
 <h3>Quelli con + goliardi</h3>

<?
$rs=getRecordSetByQuery("select o.m_fileImmagineTn as _fotoordine,nome_veloce,count(*) as quanti from ordini o,goliardi g where g.id_ordine=o.id_ord group by m_fileImmagineTn,nome_veloce order by count(*) DESC");

scriviRecordSetConTimeout($rs,10);
?>

  <h3>Quelli gestiti da CANI</h3>
   (i cui gestori metton cariche autoreferenziali, chi è informatico SA quanto sia grave: e ci rimettiamo tutti)

 <?

$rs=getRecordSetByQuery("SELECT o.m_fileImmagineTn as _fotoordine,o.[nome_veloce] as nome, o.[nome completo] from CARICHE c,ordini o WHERE o.id_ord=c.id_ordine AND ID_CARICA=ID_CAR_staSottoA");

scriviRecordSetConTimeout($rs,10);
?>

   <h3>Quelli con + nomine</h3>
<?
$rs=getRecordSetByQuery("select m_fileImmagineTn as _fotoordine,nome_veloce,count(*) as quanti from ordini o,nomine n,cariche c where c.id_carica=n.id_carica AND c.id_ordine=o.id_ord group by m_fileImmagineTn,nome_veloce order by count(*) DESC");
scriviRecordSetConTimeout($rs,10);
?>

   <h3>Il goliarda con + Active Pointz®</h3>
<br>
(s'intende: 100 pti x ogni carica <i>attiva</i> da capoordine, 10 x ogni carica nobiliare ricoperta,1 per ogni carica popolare...)
<?
$rs=getRecordSetByQuery("select [nome goliardico],count(*) as quante from goliardi g, nomine n, cariche c where n.id_goliarda=g.id_gol AND c.id_carica=n.id_carica group by g.id_gol,g.[nome goliardico] order by count(*) desc");

scriviRecordSetConTimeout($rs,10);
?>

   <h3>Il goliarda con + Nomine...</h3>
<br>
(s'intende: 100 pti x ogni carica <i>attiva</i> da capoordine, 10 x ogni carica nobiliare ricoperta,1 per ogni carica popolare...)
<?
$rs=getRecordSetByQuery("select [nome goliardico],c.attiva,c.[dignità],count(*) as quante from goliardi g, nomine n, cariche c where n.id_goliarda=g.id_gol AND c.id_carica=n.id_carica and c.hc=false group by g.id_gol,g.[nome goliardico],c.attiva,c.[dignità] order by count(*) desc");

scriviRecordSetConTimeout($rs,10);
?>



   <h3>Il goliarda con + Patacca(r) Pointz®</h3>
<br>
(s'intende: 100 pti x ogni carica <i>HC</i> da capoordine, 10 x ogni carica nobiliare ricoperta,1 per ogni carica popolare...)

  </td>
 </tr>
</table>


















?>