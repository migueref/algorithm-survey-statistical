<?php
  include_once("Database.php");
  /**
   * Question model
   */
  class Question {
    public $question_id;
    public $answer;

    function __construct($question_id, $answer)
    {
      $this->question_id = $question_id;
      $this->answer      = $answer;
    }

    static function get(){
  		$db = new Database();
  		$sql = "SELECT * FROM questions where status=1 LIMIT 50";
  		if($rows = $db->query($sql)){
  			return $rows;
  		}
  		return false;
  	}

    static function update($id) {
      $db = new Database();
  		$sql = "UPDATE questions SET status=0 WHERE id = '$id'";
      //echo $sql;
  		if($db->query($sql)){
  			return true;
  		}else{
  			return false;
  		}
    }

    static function delete($id) {
      $db = new Database();
  		$sql = "DELETE FROM questions WHERE id = '$id'";
  		if($db->query($sql)){
  			return true;
  		}else{
  			return false;
  		}
    }
  }

?>
