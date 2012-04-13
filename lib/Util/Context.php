<?php

class Context{

	private $pageID;
	private $errors = array();
	private $messages = array();
	
	public function getPageID(){
	
		return $this->pageID;
	
	}
	
	public function setPageID($pageid){
	
		$this->pageID = $pageid;
	
	}
	
	public function addError($error){
	
		$this->errors[] = $error;
	
	}
	
	public function getErrors(){
	
		return $this->errors;
	
	}
	
	public function getErrorHTML(){
		
		if(count($this->errors) == 0){
			return "";
		}
		
		$errorhtml = "<div class=\"centered error\">";
		
		foreach($this->errors as $error){
		
			$errorhtml = $errorhtml." ".$error."<br />";
		
		}
		$errorhtml = $errorhtml."</div>";
		
		return $errorhtml;
		
	}
	
	public function addMessage($message){
	
		$this->messages[] = $message;
	
	}
	
	public function getMessages(){
	
		return $this->messages;
	
	}
	
	public function getMessagesHTML(){
		
		if(count($this->messages) == 0){
			return "";
		}
		
		$msgHtml = "<div class=\"centered message\">";
		
		foreach($this->messages as $msg){
		
			$msgHtml = $msgHtml." ".$msg."<br />";
		
		}
		$msgHtml = $msgHtml."</div>";
		
		return $msgHtml;
		
	}

}

?>