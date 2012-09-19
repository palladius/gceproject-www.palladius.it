<?php
##########################################
# Glossary Component for Mambo			 #
# Copyright  : Martin Brampton			 #
# Homepage 	 : www.remository.com	  	 #
# Version    : 1.9.2           			 #
# License    : Released under GPL        #
##########################################
# Based on: 							 #
##########################################
# Glossary 1.3 (Michelle Farran)		 #
# and									 #
# AkoBook - A Mambo Guestbook Component! #
# Copyright (C) 2003  by  Arthur Konze   #
# Homepage   : www.mamboportal.com       #
# Version    : 3.0 beta 1                #
# License    : Released under GPL        #
##########################################
# Translation: Arthur Konze              #
# Homepage   : www.konze.de              #
##########################################

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class HTML_glossary {

  function showGlossaryEntries( $option, &$rows, &$search, &$pageNav, &$clist ) {

    $entrylength   = "40";

    # Table header
    ?>
    <form action="index2.php" method="post" name="adminForm">
  <table cellpadding="4" cellspacing="0" border="0" width="100%">
    <tr>
      <td width="100%" class="sectionname">
	    <img src="components/com_glossary/images/logo.png" valign="top">&nbsp;Glossary
      </td>
      <td nowrap="nowrap">Display #</td>
			<td>
				<?php echo $pageNav->writeLimitBox(); ?>
			</td>
			<td>Search:</td>
			<td>
				<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
			<td width="right">
				<?php echo $clist;?>
			</td>
    </tr>
    </table>
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
      <tr>
        <th width="2%" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" /></th>
        <th class="title" align=left><div align="left">Term</div></th>
        <th class="title" align=left><div align="left">Category</div></th>
        <th class="title"><div align="center">Published</div></th>
      </tr>
      <?php
    $k = 0;
    for ($i=0, $n=count( $rows ); $i < $n; $i++) {
      $row = &$rows[$i];
      echo "<tr class='row$k'>";
      echo "<td width='5%'><input type='checkbox' id='cb$i' name='id[]' value='$row->id' onclick='isChecked(this.checked);' /></td>";
      echo "<td align='left'><a href=\"index2.php?option=".$option."&task=edit&id=cb".$i."&id[]=".$row->id."\">$row->tterm</a></td>";
      echo "<td align='left'>$row->category</td>";

      $task = $row->published ? 'unpublish' : 'publish';
      $img = $row->published ? 'publish_g.png' : 'publish_x.png';
      ?>
        <td width="10%" align="center"><a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')"><img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="" /></a></td>

    </tr>
    <?php    $k = 1 - $k; } ?>
    <tr>
      <th align="center" colspan="7">
        <?php echo $pageNav->writePagesLinks(); ?></th>
    </tr>
    <tr>
      <td align="center" colspan="7">
        <?php echo $pageNav->writePagesCounter(); ?></td>
    </tr>
  </table>
  <input type="hidden" name="option" value="<?php echo $option;?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  </form>
<?php
}

function editGlossary( $option, &$row, &$publist, &$clist ) {
  global $mosConfig_absolute_path;
  require($mosConfig_absolute_path."/administrator/components/com_glossary/config.glossary.php");
?>
    <script language="javascript" type="text/javascript">
    function submitbutton(pressbutton) {
      var form = document.adminForm;
      <?php getEditorContents( 'editor1', 'tdefinition' ) ;?>
      if (pressbutton == 'cancel') {
        submitform( pressbutton );
        return;
      }
      // do field validation
      if (form.tterm.value == ""){
        alert( "Entry must have a term." );
      } else if (form.catid.value == "0"){
	alert( "You must select a category." );
      } else {
        submitform( pressbutton );
      }
    }
    </script>

    <table cellpadding="4" cellspacing="1" border="0" width="100%" class="adminform">
    <form action="index2.php" method="post" name="adminForm" id="adminForm">
      <tr>
	    <td width="100%" class="sectionname">
	      <img src="components/com_glossary/images/logo.png" valign="top">&nbsp;Glossary
        </td>
	  </tr>
	  <tr>
        <th colspan="2" class="title" >
          <?php echo $row->id ? 'Edit' : 'Add';?> Glossary Entry
        </th>
      </tr>
      <tr>
        <td valign="top" align="right">Term:</td>
        <td>
          <input class="inputbox" type="text" name="tterm" value="<?php echo $row->tterm; ?>" size="50" maxlength="100" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right">Definition:</td>
        <td width="420" valign="top"><?php editorArea( 'editor1',  $row->tdefinition, 'tdefinition', '500', '200', '70', '30' ) ; ?></td>
      </tr>

     <tr>
				<td valign="top" align="right">Category:</td>
				<td>
					<?php echo $clist; ?>
				</td>
			</tr>

      <tr>
        <td width="20%" align="right">Name:</td>
        <td width="80%">
          <input class="inputbox" type="text" name="tname" size="50" maxlength="100" value="<?php echo htmlspecialchars( $row->tname, ENT_QUOTES );?>" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right">E-Mail:</td>
        <td>
          <input class="inputbox" type="text" name="tmail" value="<?php echo $row->tmail; ?>" size="50" maxlength="100" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right">Homepage:</td>
        <td>
          <input class="inputbox" type="text" name="tpage" value="<?php echo $row->tpage; ?>" size="50" maxlength="100" />
        </td>
      </tr>
      <tr>
        <td valign="top" align="right">Comment:</td>
        <td>
          <textarea class="inputbox" cols="50" rows="3" name="tcomment" style="width=500px" width="500"><?php echo htmlspecialchars( $row->tcomment, ENT_QUOTES );?></textarea>
        </td>
      </tr>

      <tr>
        <td valign="top" align="right">Published:</td>
        <td>
          <?php echo $publist; ?>
        </td>
      </tr>

    </table>

    <input type="hidden" name="tdate" value="<?php echo time(); ?>" />
    <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    </form>
<?php
  }

function showAbout() {
	?>
    <table cellpadding="4" cellspacing="0" border="0" width="100%">
	<tr>
	  <td width="100%" class="sectionname">
	    <img src="components/com_glossary/images/logo.png" valign="top">&nbsp;Glossary
      </td>
	</tr>
    <tr>
		<td>
        <p><b>Glossary</b><br>
        The glossary component was originally based on Arthur Konze's (www.mamboportal.com)
		Akobook Guestbook component and on the Weblinks component (www.mamboserver.com). It has
		subsequently been extensively rewritten by Martin Brampton (www.remository.com).</p>
        <p><b>License</b><br>
        Glossary is free software; you can redistribute it and/or modify it under the terms
        of the <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GNU General
        Public License</a> as published by the Free Software Foundation. This program is
        distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
        even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
        See the GNU General Public License for more details.</p>
		<p>Up to version 1.3 the Glossary was developed by Michelle Farren; development
		was then carried forward up to version 1.5 by Sascha Claren.
		All upcoming versions are developed and released by Martin Brampton
		( <a href="http://www.remository.com" target="_blank">www.remository.com </a> ) 
		and Bernhard Zechmann ( <a href="http://www.zechmann.com" target="_blank">www.zechmann.com </a> )</p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
		">
		</form>
		</td>
	</tr>
	</table>
	<?php
}

# End of class
}
?>
