<?
	$titolo = "indovinelli";
	require_once("header.php");
?>
<!---
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="Author" content="Riccardo carlesso">
   <meta name="GENERATOR" content="Mozilla/4.7 [en] (Win98; I) [Netscape]">
   <title>archivio\homepage\matematica</title>
</head>
<body text="#000000" bgcolor="#FFFFFF" link="#FF0000" vlink="#800080" alink="#0000FF" nosave>
&nbsp;
<center><table BORDER COLS=1 WIDTH="60%"  NOSAVE >
<tr>
<td>
<center><b><font ><font size=+4>Indovinelli</font></font></b></center>
</td>
</tr>
</table></center>
--->
<?
function indovinello_titolo($titolo)
{
echo "<br><center><b><font size=+0>".$titolo."</font></b></center>";
}

function intro_ric($str)
{
echo "<table><tr><td valign=top><img src='img/2003/palladius_frac.jpg' height='80'></td><td>$str</td></tr></table>";
}
?>

<center><h1>Indovinelli</h1></center>

<? intro_ric("Questa pagina riunisce una serie di indovinelli che ho letto o sentito in giro. Affascinano molto la maggior parte delle mi conoscenze, quindi ho pensato di aggiornarlo e aggiungere gli ultimi che ho sentito... (addì 12 Aprile 2004). In alto vi saranno i più nuovi...<br><b>N.B.</b> Per le soluzioni inventerò una strategia, per ora li cancello e basta... meglio non vederlo che vederlo. Non tutti hanno lo sforzo così possente da non leggere quando vien data la possibilit&agrave;... Se ne avete di nuovi, <a href='mailto:palladius@palladius.it'>mandatemeli</a>!!!");
?>

<? indovinello_titolo("Il pirati e il tesoro"); ?>
<i>Questo mi fu raccontato da una mia amica e devo ammettere essere il mio preferito. Purtroppo una volta capito il trucco i calcoli vengono abbastanza semplici., Credo si riconduca (ma sono ignorante a rguardo) alla teoria dei giochi di Nash.</i><br>
Cinque pirati devono spartirsi un tesoro di 1000 monte d'oro. Tra di loro c'è una gerarchia, quindi diremo che l'1 e' il capo e cosi' via fino al 5 che e' l'ultimo sfigato. Il capo ha la seguente idea che impone per dividersi il denaro: l'ultimo fa una proposta di suddivisione (con essa intendendo una spartizione del denaro tale che la somma ammonti a 1000, da tutti a me a 200  a testa, fino a spartizioni piu' fantasiose). Qualunque essa sia, tutti i presenti votano. Se si ha la maggioranza assoluta dei voti a favore (nel caso, 3 voti a favore), il gioco finisce e si fa esegue la proposta. Se no, il quinto viene ucciso e toccherà al quarto fare una suddivisione tra i rimanenti 4, e cosi' via finche' eventualmente non rimane il capo da solo. Sapendo che i 5 pirati sono logici eccellenti e che vogliono massimizzare il proprio profitto (e ancor piu' vogliono rimanere vivi), dire che proposta fara' il quinto. Clausola: i pirati voteranno in modo da massimizzare il loro profitto; se una soluzione mi da' x e votandoti contro so che dopo avro' anche solo una moneta in piu', ti votero' contro; se tu mi dai anche solo una moneta in piu', ti votero' a favore; in caso di parita' i pirati son sanguinari e votano la morte del compagno.<br>
La soluzione c'e', in particolare ve ne sono due equivalenti. ;-)


<? indovinello_titolo("Il ponte e i 4 attraversatori"); ?>
Ci sono quattro persone che devono attraversare un ponte e possiedono una torcia. E' buio e molto stretto quindi il ponte può essere attraversato al piu' da due persone e comuqnue occorre sempre avere la torcia con se'. Sapendo che queste quattro persone sono un velocista, un atleta, una persona normale e una obesa e quindi impiegano rispettivamente 1,2,5 e 10 minuti per attraversare il ponte (e che ovviamente la velocita' di una coppia e' uguale alla velocita' del piu' lento), qual e' il tempo minimo che occorre al gruppo per passare il ponte?!? (Attenzione, <i>non</i> è 19, se no mi licenziereste subito!)

<? indovinello_titolo("Le tre lampadine"); ?>
<i>Questo e' un tipico indovinello di logica che dev'essere cvoadiuvato dal buon senso. Non esiste un sistema logico/assiomatico per risolverlo, occorre improvvisare un po'. Se siete elettricisti, siete avvantaggiati, insomma.</i><br>
Un uomo è in una stanza con 3 interruttori. Essi comandano 3 lampadine che sono dall'altra parte della stanza. Egli deve scoprire quale interruttore comanda quale lampadina; ha la possibilita' di armeggiare tutto il tempo che vuole con tutti e 3 gli interruttori, ma puo' andare dall'altra parte (ovvero aprire la porta, che senno' e' a tenuta stagna di luce) solo una volta. Da cio' che vede deve indovinare le combinazioni. Come fa?

<? indovinello_titolo("130 fattoriale"); ?>
<i>Questo indovinello l'ho trovato tra i problemi di matematica d'ingresso della Normale di Pisa. Semplice, ma molto carino (a mio avviso)</i>. E' comunque meno immediato di quanto sembri. ;-)<br>
Con quanti zeri termina il numero <i>130!</i> ???

<? indovinello_titolo("I prigionieri coi cappelli"); ?>
<i>Mi son spesso chiesto perche' pulluli cosi' tanto di indoovinelli coi capppelli... secondo me perche' e' un modello visivamente grazioso su una proprieta' che TUTTI vedono tranne l'interessato. L'indovinello che segue contiene un trucco.. o lo si indovina in 30 secondi o in 30 anni. o vie di mezzo. :-) Se non lo risolvete, non perderete il mio rispetto poiche' contiene un trucco che lo rende un indovinello abbastanza stupido (a mio avviso).</i><br>
Ci sono dei prigionieri, <i>n</i> con un cappello nero e <i>m</i> con un cappello bianco. Questi vengono fatti entrare a turno (uno alla volta) in una stanza enorme. Questi non sanno il proprio colore, ma devono disporsi in modo che quando l'ultimo si sia piazzato vi sia effettivamente la metà bianca TUTTA da uno stesso 'lato' della stanza e la metà nera tutta dall'altro. Non gli si dice se disporsi a matrice, a lista, a spirale e così via, solo di disporsi e basta. Se alla fine ci sono degli 'enjambements' tipo BNBN, diciamo che gli si spara a tutti allegramente.

<? indovinello_titolo("I tre computer"); ?>
<i>Questa e' una versione un po' piu' complicata dell'indovinello delle due tribu' (che trovate piu' in basso in questa stessa pagina). In realta' credo sia opportuno risolvere prima l'altro indovinello, e poi cimentarsi con questo.</i><br>
In una stanza ci sono tre computer e due porte. Una di queste porta a morte certa, l'altra alla salvezza. Una persona deve trovare la via di fuga e puo' appellarsi solo alle tre macchine. Esse sono caratterizzate nel seguente modo: una dice sempre il vero, una dice sempre il falso (ovvero risponde l'esatto opposto di una macchina sincera, ma senza malizia alcuna) e la terza risponde sempre a caso (con esso intendendo che puo' dire sempre la verita', sempre bugie, meta' e meta'... non c'e' correlazione tra le sue risposte!); inoltre c'e' mutua conoscenza: chi mente sa di mentire, il random sa di essere random e queste conoscono anche l'identita' delle altre due. Con questi dati, sapreste trovare TRE domande di tipo vero/falso da fare a questi tre computer (ovviamente, non sapete chi sia il random chi il sincero chi il bugiardo!) x trovare la porta giusta?<br>
<b>PS</b> Il mio capo c'e' riuscito con due, sotto l'ulteriore ipotesi che si possa 'forgiare' una domanda dipendentemente dall'esito della domanda/risposta precedente, il che mi sembra assolutamente ragionevole.

<? indovinello_titolo("Le due trib&ugrave; "); ?>
<i>Questo indovinello l'ho trovato sia in un libro di indovinelli matematici
di Martin Gardner che nel film Labirinth. E' di un'eleganze notevole...</i>
<br>Un esploratore si disperde in africa. Si trova a un bivio. Sa che una
via conduce a morte certa, l'altra alla salvezza. Vede due abitanti di
due trib&ugrave; diverse. Sa che l&igrave; vicino ci sono due trib&ugrave;:
una di sinceri, una di bugiardi (puntualizziamo: i bugiardi non sono cos&igrave;
intelligenti da rispondere in modo che tu sbagli e muori, semplicemente
dicono il contrario di quel che dovrebbero dire: non sono <i>maliziosi</i>
per intenderci). Ebbene, sa che uno &egrave; sincero e uno bugiardo ma
non sa chi &egrave; uno chi l'altro. Ha a disposizione <i>una sola domanda
</i>da porre a uno dei due. Che domanda deve porre per sapere la strada giusta?

<!---
<p><font face="Wingdings"><font size=-5>Una domanda possibile &egrave;:
<i>"L'altro
quale direbbe che sia la strada giusta?!?" </i>Cos&igrave; o dice la verit&agrave;
di una risposta sbagliata o la bugia di una risposta giusta, e in ogni
caso otterr&agrave; la strada sbagliata; gli rimarr&agrave; da seguire
l'altra. Una <i>mia </i>interpretazione &egrave;: la verit&agrave; &egrave;
disponibile all'interno di due scatole nere che filtrano all'esterno con
una caratteristica: '1' per la scatola sincera, '-1' per la bugiarda. Sono
filtri involutivi anche se l'involutivit&agrave; &egrave; macchinosa da
sfruttare: ('Pensa mentalmente a cosa mi risponderesti se ti chiedessi
la strada giusta: dimmi de mi diresti che &egrave; quella l&igrave;' per
esempio!). Tanto vale mettere i due filtri in serie sfruttando la commutativit&agrave;
del prodotto di queste 'funzioni di trasferimento' e otteniamo la certezza
del prodotto: '-1', cio&egrave; una bugia</font></font>
<br>
--->

<? indovinello_titolo("Il buco nella sfera"); ?>

<i>Questo indovinello l'ho trovato nel famoso libro di indovinelli matematici
di Martin Gardner. Elegante in quanto sembra mancare di dati sufficienti
alla sua soluzione!!!</i>
<br>Una sfera di raggio ignoto viene forata da un trapano di raggio altrattanto
ignoto. La differenza dei due raggi &egrave; 3 centimetri. Qual &egrave;
il volume residuo della sfera bucata (che io amo chiamare 'portatovaglioli di rotazione')?!?
<!---
<p><font face="Wingdings"><font size=-1>[Se consideriamo la sfera di raggio
R e il trapano di raggio r parrebbe che a seconda di r e R possiamo ottenere
il volume residuo in funzione di entrambi; in realt&agrave; &egrave; funzione
della loro sola differenza!!! Il calcolo non &egrave; agevole n&eacute;
lo star&ograve; a rifare. Un modo per arrivare alla soluzione &egrave;
dire: beh, se mi dici che non dipende da R e r prendo un caso comodo: R=3
cm e r=0: ho una sfera con un buco nullo: il volume &egrave; 4/3pigreco
R cubo cio&eacute; 36 pigreco]</font></font>
<br>&nbsp;
<br>&nbsp;
<br>
--->
<? indovinello_titolo("La regina di Atlantide e i tradimenti"); ?>


<p><i>Questo indovinello l'ho trovato in internet; secondo me &egrave;
irrisolubile da essere umano. Per sicurezza NON allego la soluzione e spero
in una vostra
<a href="mailto:palladius@email.it">mail</a> in cui mi dimostriate
il contrario!</i> <i>PS <a href="mailto:noferini@ibm.net">Vanni Noferini</a> ha trovato
la soluzione...</i>
<br>Siamo nell'antica atlantide, regno matriarcale comandato dalla regina
Henrietta (non sposata). Tutte le donne di atlantide prima di sposarsi
devono sostenere un difficilissimo problema di logica: possiamo tranquillamente
assumere che queste possano dedurre tutto il deducibile da un set di ipotesi.
Queste sono anche molto pettegole, quindi se una andasse a letto col marito
di un'altra, tutte le donne sposate eccetto quest'ultima lo saprebbero;
questo &egrave; un dato che sanno anche loro (in altre parole, ogni donna
ha visibilit&agrave; di TUTTI i tradimenti tranne eventualmente di quello
del proprio marito). Ebbene, un bel giorno la regina Enrietta raduna tutte
le donne sposate dicendo loro: "C'&egrave; almeno un tradimento qui ad
atlantide. Se voi doveste scoprire che vostro marito vi tradisce gli dovete
sparare esattamente alla mezzanotte del giorno in cui lo scoprite."Passano
41 notti tranquille, finch&eacute; alla XXXXII notte si sentono degli spari.
<br>Quanti e perch&eacute;?


<? indovinello_titolo("Tutte le bionde hanno gli occhi azzurri"); ?>

<p><i>Questo non e' un indovinello, quanto un elegante esempio di dimostrazione per induzione con un errore.
Trovate il bug di questa dimostrazione che ho trovato su un libro di Analisi I (mi pare il giusti)...</i>
<br><b>Teorema.</b> Date n bionde, se una ha gli occhi azzurri, tutte hanno
gli occhi azzurri.
<br><b>Dimostrazione</b> (per induzione).
<br>Premessa induttiva. Data una bionda, una=tutte: o tutte o nessuna,
quindi &egrave; ovvio!
<br>Passaggio da n a n+1. Sia vero per n bionde che se una ha gli occhi
azzurri allora tutte hanno gli occhi azzurri. Ne ho n+1. Tolga l'ultima
(Pina): se nessuna delle rimanenti ha gli occhi azzurri tutto bene; se
una ha gli occhi azzurri, allora tutte e n li hanno azzurri. Rimane Pina:
tolgo Gina (la penultima) e inserisco Pina: ho un altro insieme di n persone.
Anche Pina avr&agrave; dunque gli occhi azzurri ed il teorema rimane dunque
dimostrato.
<br><b>Corollario.</b> Una mia amica di Argenta (giuro!) ha capelli biondi e occhi
azzurri. Dunque tutte le bionde del mondo hanno gli occhi azzurri.


<center><h2>Indovinelli filosofici</h2></center>

<? indovinello_titolo("La palla di cannone e il muro"); ?>
Cosa succede se una irresistibile palla di cannone colpisce un muro inamovibile?

<? indovinello_titolo("Dio e' onnipotente?"); ?>
Dio puo' creare una palla cosi' dura che non puo' poi rompere?


<center><h2>Per bambini...</h2></center>

<? indovinello_titolo("Il bruco e il muro"); ?>
Un bruco sale lentamente un muro di 10 metri. Ogni di' sale di 3 metri. Ma la notte si addormenta e cade giu' di due. Dopo quanti giorni arriva in cima?<br>
<i>(no, non sono 10!)</i>

<? indovinello_titolo("Le ninfee"); ?>
Un lago si riempie ogni giorni di ninfee, e ogni giorno  ha un numero di ninfee doppio del giorno prima. Dopo venti giorni è completamente pieno. Dopo quanti, allora, era pieno a meta'?<br>
<i>Problema semplicissimo, ma si noti che un mio amico ingegnere mi propose come risposta radice di venti. Interessante, nevvero?</i>


<? indovinello_titolo("Somma dei primi 100 numeri"); ?>
Narra la leggenda che un giorno la classe di Gauss stesse facendo moolto casino. Per punizione la maestra, che evidentemente era mestruata, aveva mal di testa, e aveva voglia di un po' di silenzio, impose ai suoi bimbi di trovare la somma dei primi cento numeri. Dopo meno di un minuto, il piccolo Gauss arriva alla cattedra con la soluzione (che, tanto x darvi una mano, è circa 7! più un paio di manciate) esatta. Ora la domanda che mi pongo io e': la maestra fu abbastanza intelligente da cambiare esercizio o gli propose di fare la somma dei primi mille?



<center><h2>Linkz...</h2></center>

--- <a href="http://www.ocf.berkeley.edu/~wwu/riddles/hard.shtml">Qua c'e' quello dei pirati e tanti altri, MOOOLTO carini.</a>