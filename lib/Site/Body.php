<?php

abstract class Body{
	
	abstract function getMinimumUserLevel();
	abstract function getTitle();
	abstract function getScriptsHTML();
	abstract function generateHTML();
	
}

?>