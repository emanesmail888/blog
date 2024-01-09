<?php 

class Check {


function slug($str, $limit = null) {
    if ($limit) {
        $str = mb_substr($str, 0, $limit, "utf-8");
    }
    $text = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    return $text;
}


// public function title(){
// 		$path = $_SERVER['SCRIPT_FILENAME'];
// 		$title = basename($path, '.php');
// 		$title = str_replace('_', " ", $title);
// 		if ($title == 'index') {
// 			$title = 'Home';
// 		}elseif ($title == 'contact'){
// 			$title = 'Contact';
// 		}
// 		return $title = ucwords($title);
// 	}

	
	


}


 ?>