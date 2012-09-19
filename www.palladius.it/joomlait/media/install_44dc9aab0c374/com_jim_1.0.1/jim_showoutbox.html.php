	<form method="post" action="index.php" name='jimform'>
		<table cellspacing="1" cellpadding="3" border="0" width="100%">
			<tr>
				<th colspan="5" class="Jimtitle">
				</th>
			</tr>
			<tr>
				<th class="sectiontableheader"><input TYPE="CHECKBOX"  name="allbox"   onClick="CheckAll()"></th>
				<th class="sectiontableheader"><?php echo _JIM_READ_STATUS?></th>

				<th class="sectiontableheader" width=100% align="left"><?php echo _JIM_SUBJECT?></th>
				<th class="sectiontableheader"><?php echo _JIM_TO?></th>
				<th class="sectiontableheader" ><?php echo _JIM_SENTDATE?></th>
			</tr>	
<?php
	if ( count($rows) < 1 ) { ?>
		<tr class="sectiontableentry1">
			<td colspan="5" align="center">
				<?php echo _JIM_NO_MSG; ?>
			</td>
		</tr>
<?php
	} else {
	$i = 0;
		foreach ($rows as $row) {
		      $subject = "\n\n". str_replace( "\'" , "'", $row->subject);?>
		<tr class="sectiontableentry<?php echo $k+1; ?>">
			<td>
				<input type="checkbox" name="leave[<?php echo $row->id?>]" value="del">
			</td>
			<td align=center>
				<img src="<?php echo $mosConfig_live_site."/components/com_jim/images/".$row->readstate.".png"?>" border="0">
			</td>
			<td>
				<a href="index.php?option=com_jim&task=viewsent&id=<?php echo $row->id?>" /><?php echo $subject?></a>
			</td>
			<td>
<?php
			if ($JimConfig["link2cb"] == _CMN_YES) {
?>
				<a href="index.php?option=com_comprofiler&task=userProfile&user=<?php echo $row->uid?>">
<?php
			echo $row->username;
?>
				</a>
<?php 
			}else{

			echo $row->whofrom;
			}
?>
			</td>
			<td  align=center nowrap>
<?php		echo $row->date; ?>
			</td>
		</tr>

<?php
			$k=1-$k;
			$i++;
		}
	}
?>  
		<tr class="sectiontableheader" >
			<td colspan="5">
				<input type="button" name="leaveme" class='button' value="<?php echo _JIM_DELETE_SEL?>" onclick="document.jimform.task.value='leavemsgs';document.jimform.submit();">
		   </td>
		</tr>

		<tr  >
			<td colspan="5" align="center">
<?php
	$pageNav->writePagesCounter();
	echo $pageNav->writePagesLinks("index.php?option=com_jim&amp;page=outbox");
	echo "<br>";
	echo $pageNav->writeLimitBox("index.php?option=com_jim&amp;page=outbox");
?>
			</td>
		</tr>

	</table>
	<input type="hidden" name="option" value="com_jim">
	<input type="hidden" name="task" value="outbox">
</form>

