<?php

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

class mosGlossary extends mosDBTable {
  var $id=null;
  var $tname=null;
  var $tmail=null;
  var $tpage=null;
  var $tloca=null;
  var $tterm=null;
  var $tdefinition=null;
  var $tdate=null;
  var $tcomment=null;
  var $tedit=null;
  var $teditdate=null;
  var $published=null;
  var $catid=null;
  var $checked_out=null;

  function mosGlossary( &$db ) {
    $this->mosDBTable( '#__glossary', 'id', $db );
  }

}
?>