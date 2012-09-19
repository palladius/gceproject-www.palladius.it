<?php defined( "_VALID_MOS" ) or die( "Direct Access to this location is not allowed." );$iso = split( '=', _ISO );echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html;><?php echo _ISO; ?>" />
<?php if ( $my->id ) { initEditor(); } ?>
<?	/**
	 *  created by Jooon.de
  	 *  http://jooon.de	
	 *
	 *	PostNuke 4.6.1 (Phoenix) with Autotheme
	 *	20-10-2003
 	 *
	 *	Copyright (C) 2003 Jooon.de 
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left 
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *  Ported to Mambo 4.5 by:
	 *		Lawrence Meckan
	 *		Absalom Media
	 *		http://www.absalom.biz
	 *	
	 *	Version 1.0A 
	 * 	
	 * 	Updated to Mambo 4.5.1
	 * 	By Absalom Media
	 * 	Date:	15th October 2004
 **/
?>

<link href="templates/manga/css/template_css.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<br><br><table border="0" cellpadding="4" cellspacing="0" width="760" align="center"><tr><td bgcolor="#ffffff"><table border="0" cellspacing="0" cellpadding="6" width="100%" bgcolor="#ffffff" background="templates/manga/images/logo_jooon.jpg">
	<tr><td align="left" valign="bottom" height="124"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="2" bgcolor="#990000">&nbsp;</td>
    <td>&nbsp;<a href="index.php" class="title"><?php echo $mosConfig_sitename; ?></a><br><font class="subtitle">&nbsp;Your slogan here</font></td>
  </tr>
</table><br></td></tr></table></td></tr><tr><td valign="top" width="100%" bgcolor="#ffffff"><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>		
			<td valign="top" width="150" bgcolor="#ffffff"><table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000">
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td bgcolor="#ffffff" class="pn-title">&nbsp;Newsflash <img src="templates/manga/images/upb.gif" border="0" alt=""></a></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ffffff">
					  <?php mosLoadModules ( 'top' ); ?>
                      </td>
                    </tr>
                </table></td>
              </tr>
            </table>
			
			<br>
			
			
              <table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr>
                        <td bgcolor="#ffffff" class="pn-title">&nbsp;Main Menu <img src="templates/manga/images/upb.gif" border="0" alt=""></a></td>
                      </tr>
                      <tr>
                        <td bgcolor="#ffffff"><?php mosLoadModules ( 'left' ); ?></td>
                      </tr>
                  </table></td>
                </tr>
              </table>
              <br>
              
			  
				<table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
                        <tr>
                          <td bgcolor="#ffffff" class="pn-title">&nbsp;Online <img src="templates/manga/images/upb.gif" border="0" alt=""></td>
                        </tr>
                        <tr>
                          <td bgcolor="#ffffff"><?php mosLoadModules ( 'user1' ); ?></td>
                        </tr>
                    </table>
					</td>
                  </tr>
              </table>
			  

              </td><td>&nbsp;&nbsp;</td>
          <td valign="top"><table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000"><tr><td><table width="100%" border="0" cellspacing="0" cellpadding="3"><tr><td bgcolor="#ffffff" class="pn-title"></td></tr><tr><td bgcolor="#ffffff" class="pn-normal">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td><?php include ("mainbody.php"); ?><br/>
<?php mosLoadModules ( 'bottom' ); ?>
</td>
</tr></table></td></tr></table></td></tr></table><br></td>
              <td>&nbsp;&nbsp;</td>
            <td valign="top" width="150" bgcolor="#ffffff">                <table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td bgcolor="#ffffff" class="pn-title">&nbsp;Polls <img src="templates/manga/images/upb.gif" border="0" alt=""></td>
                        </tr>
                        <tr>
                          <td bgcolor="#ffffff"><?php mosLoadModules ( 'right' ); ?></td>
						  </tr>
                    </table></td>
                  </tr>
              </table>              
			  <br>
              
			  
				<table border="0" cellspacing="1" cellpadding="0" width="100%" bgcolor="#000000">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="1">
                        <tr>
                          <td bgcolor="#ffffff" class="pn-title">&nbsp;Statistics <img src="templates/manga/images/upb.gif" border="0" alt=""></td>
                        </tr>
                        <tr>
                          <td bgcolor="#ffffff"><?php mosLoadModules ( 'user2' ); ?></td>
                        </tr>
                    </table>
					</td>
                  </tr>
              </table>
			</td></tr></table>
          <center>
            <p><a href="http://jooon.de" class="layout" target="_blank">I&nbsp;Theme
                by jooon.de</a>&nbsp;<a href="http://www.absalom.biz" class="layout" target="_blank">Port by Absalom Media&nbsp;I</a><br>
              <br>
                All logos and trademarks in this site are property of their respective
                owner. The comments are property of their posters, all the rest
                (c) 2003/2004 by Jooon.de and Absalom Media <br />
                This web site was made with <a href="http://www.mamboserver.com" target="_blank">Mambo
                4.5.1</a>. Mambo 4.5.1 is Free Software
                released under the <a href="http://www.gnu.org" target="_blank">GNU/GPL
                license</a>.<br />
              </font>            </p>
</center></body>
</html>