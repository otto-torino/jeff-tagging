<?php

define("TBL_TAG_NAME", "tag_name");
define("TBL_TAG_JOIN", "tag_join");

class tagging {

	private $_registry;

	function __construct($registry, $opts=null) {

		$this->_registry = $registry;

	}

	public function adminList($opts, $value) {
		
		return $value;

	}

	public function adminDelete($opts, $f_s) {
		$res = $this->_registry->db->delete(TBL_TAG_JOIN, "`table`='".$opts['table']."' AND table_id IN (".implode(",", $f_s).")");
	}

	public function formAdmin($opts, $fname, $flabel, $field, $myform, $value) {

		$this->_registry->addCss(relativePath(dirname(__FILE__).DS.'MooComplete.css'));
		$this->_registry->addJs(relativePath(dirname(__FILE__).DS.'MooComplete.js'));

		$tags = $this->_registry->db->autoSelect(array("name"), TBL_TAG_NAME, "", "name");
		$tags_list = array();
		if(count($tags)) 
			foreach($tags as $tag) 
				$tags_list[] = trim($tag['name']);

		$required = $field['null']=='NO' ? true : false;

		$input = $myform->cinput($fname, 'text', $value, array($flabel, __("tag1,tag2,tag3")), array("required"=>$required, "size"=>40, "maxlength"=>"512", "id"=>$fname));
		$script = "<script>window.addEvent('domready', function() {
  					new MooComplete('$fname', {
    						list: ['".implode("','", $tags_list)."'],
						mode: 'tag'
  					});
				})
			</script>";

		return $input."\n".$script;
	}

	public function cleanField($opts, $model, $fname, $pkf, $insert) {
		$model->{$fname} = cleanInput('post', $fname.'_'.$pkf, 'string');
	}

	public function afterModelSaved($opts, $model, $fname, $pk, $insert) {

		$res = $this->_registry->db->delete(TBL_TAG_JOIN, "`table`='".$opts['table']."' AND table_id='$pkf'");
		$tags = explode(",", $model->{$fname});
		foreach($tags as $t) {
			$t = trim($t);
			$rows = $this->_registry->db->autoSelect('id', TBL_TAG_NAME, "name='$t'", null);
			if(count($rows)) $tid = $rows[0]['id'];
			else $tid = $this->_registry->db->insert(TBL_TAG_NAME, array("name"=>$t));
			
			$res = $this->_registry->db->insert(TBL_TAG_JOIN, array("tag_id"=>$tid, "table"=>$opts['table'], "table_id"=>$model->{$pk}));

		}

	}

}

?>
