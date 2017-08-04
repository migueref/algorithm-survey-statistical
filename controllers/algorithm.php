<?php
require_once("../models/Question.php");
  /**
   * Get questions
   */
  $elements = Question::get();
  $i = 0;
  /**
   * Count elements to get limit size
   */
  $length = count($elements);
  /**
   * Looking for duplicate entries, you have posibilities for logic or physical delete of database records
   */
  foreach ($elements as $element) {
    if ($i < $length-1) {
      if ( $element["question_id"] == $elements[$i+1]["question_id"] ) {
        if ($element["question_id"] == 1 ) {
          //Question::delete($element["id"]);
          Question::update($element["id"]);
        } elseif ( $element["question_id"] == 10 ) {
          //Question::delete($elements[$i+1]["id"]);
          Question::update($elements[$i+1]["id"]);
        } elseif( $element["question_id"] != 1 && $element["question_id"] != 10 ){
          //Question::delete($element["id"]);
          Question::update($element["id"]);
        }
      }
      $i++;
    }
  }
  /**
   *  Get lastest tests
   */
  $elements = Question::get();
  $length = count($elements);
  $k=1;
  $j=0;
  $firstPosition=$j;
  $invalidos=0;
  $isValid=true;
  $incompletedEntries = array();
  while( $j < $length-1 ) {
    if( $k == 1 ) {
      $firstPosition=$j;
    }
    /**
     * Searching valid group of answers
     */
    if( $k!=1 ) {
      if( $elements[$j]["question_id"]!=1 ) {
        if( $elements[$j]["question_id"] != $k && $isValid) {
          $invalidos++;
          /**
           * Ignore invalid entries
           */
          while ( $elements[$j]["question_id"]!=1 ) {
            $j++;
          }
          /**
           * Decrement one position in array
           */
          $j--;
          /**
           * Save the first question position for invalid tests
           */
          array_push($incompletedEntries,$firstPosition);
          $firstPosition = $j;
          $isValid = false;
        }
        /**
         * Increment question number if it's a valid question
         */
        if( $isValid && $k<10 ){
          $k++;
        } else {
          /**
           * Initialize
           */
          $k=1;
          $isValid = true;
        }
      }

    }
    /**
     * Increment the counter if it's the first question
     */
    elseif( $k == 1 && $elements[$j]["question_id"] == 1) {
      $k++;
    }
    /**
     * Is an invalid group if the first is not equals to 1
     */
    elseif( $k == 1 && $elements[$j]["question_id"] != 1) {
      $isValid=false;
      $invalidos++;
      while ( $elements[$j]["question_id"]!=1) {
        $j++;
      }
      $j--;
      /**
       * Save initial question position for invalid tests
       */
      array_push($incompletedEntries,$firstPosition);
      $firstPosition = $j;
      $isValid = false;
      if( $isValid && $k<10 ) {
        $k++;
      } else {
        $k=1;
        $isValid = true;
      }
    }
    $j++;
  }
  /**
   * Show the number of invalid test
   */
  echo( "Invalid test: ".count($incompletedEntries) );
  foreach ( $incompletedEntries as $firstPosition ) {
    $primerElemento=$firstPosition;
    /**
     * Delete while not found a valid entry
     */
    while( $elements[$firstPosition]["question_id"] != 1 || $firstPosition == $primerElemento) {
      echo( "\nQuestion deleted: ".$elements[$firstPosition]["id"] );
      Question::update($elements[$firstPosition]["id"]);
      $firstPosition++;
    }
  }
