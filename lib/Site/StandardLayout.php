<?php

require_once "Layout.php";

class StandardLayout extends Layout{

	public function generateHTML(){

	$page = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" >

<head>

	<title>".$this->getBody()->getTitle()."</title>
	<link rel=StyleSheet href=\"./css/style.css\" type=\"text/css\">
	
	<link type=\"text/css\" href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css\" rel=\"stylesheet\" />
	
	<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js\"></script>
	<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js\"></script>
	
	".$this->getBody()->getScriptsHTML()."
	
	</head>

	<body>
	
	<center><img src=\"./images/banner.png\"></center>
	<table class=\"main\">
		
		".$this->getNavigation()->generateHTML()."
		
		<tr>
		
			<td class=\"content\">
			
				
				".$this->getBody()->generateHTML()."
			
			<br></td>
		
		</tr>
	
	</table>
	<div class=\"footer\">Created By <a href=\"mailto:apmelton@radford.edu\">Andrew Melton</a> for <a href=\"http://www.radford.edu/content/radfordcore/home/student-life/student-media.html\" target=\"_blank\">Radford University Student Media</a></div>
	
	</body>

</html>";
		
		return $page;
	
	}

}

?>