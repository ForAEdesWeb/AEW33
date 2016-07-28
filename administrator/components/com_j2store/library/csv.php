<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');


class J2StoreCSVExport {
	public $headerAry = array();
	public $dataAry = array();
	public $directory = './';
	public $filename = 'j2store_orders_export_';
	public $filepath = '';

	function __construct() {

		$this->directory = JPATH_ADMINISTRATOR.'/components/com_j2store/backup/';
	}

	public function init(){
		$this->filename = $this->filename.'_'.date('Y-m-d').'_'.time();
		$this->filepath = $this->directory.$this->filename;

	}

	public function csv(){
		$this->init();
		$this->filepath = $this->filepath.".csv";
		$handle = fopen($this->filepath, 'w+');
		fputcsv($handle, $this->headerAry);
		foreach($this->dataAry as $csvdata){
			fputcsv($handle, $csvdata);
		}
		fclose($handle);
	}

	public function download(){
		if (file_exists($this->filepath)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($this->filepath));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($this->filepath));
			ob_clean();
			flush();
			readfile($this->filepath);
		}
		else {
			echo $this->filepath.' Doesnt Exist!';
		}
	}

	public function delete(){
		unlink($this->filepath);
	}
}
?>
