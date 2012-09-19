<?php

class glossaryGlossary {
	var $gl_allowentry = '';
	var $gl_autopublish = '';
	var $gl_notify = '';
	var $gl_notify_email = '';
	var $gl_thankuser = '';
	var $gl_perpage = '';
	var $gl_sorting = '';
	var $gl_showrating = '';
	var $gl_anonentry = '';
	var $gl_hideauthor = '';
	var $gl_showcategories = '';
	var $gl_beginwith = '';
	var $gl_shownumberofentries = '';
	var $gl_showcatdescriptions = '';
	var $gl_useeditor = '';

	function glossaryGlossary() {
		global $mosConfig_absolute_path;
		require($mosConfig_absolute_path."/administrator/components/com_glossary/config.glossary.php");
		foreach (get_class_vars(get_class($this)) as $k=>$v) {
			if(isset($$k)) {
				$this->$k = $$k;
			} else {
				$this->$k = '';
			}
		}
	}

	function abc () {
		return array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	}

	function abcplus () {
		return array_merge(array(_GLOSSARY_ALL),glossaryGlossary::abc(),array(_GLOSSARY_OTHER));
	}

	function abcplus_key () {
		return array_merge(array('All'),glossaryGlossary::abc(),array('Other'));
	}
}

class glossaryEntry {
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
}

?>
