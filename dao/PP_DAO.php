<?php
namespace PP\DAO;

class PP_DAO {
    private $PDOX;
    private $p;

    public function __construct($PDOX, $p)
    {
        $this->PDOX = $PDOX;
        $this->p = $p;
    }

    function getMainId($context_id, $link_id)
    {
        $query = "SELECT main_id FROM {$this->p}pp_main WHERE context_id = :context_id AND link_id = :link_id;";
        $arr = array(':context_id' => $context_id, ':link_id' => $link_id);
        $context = $this->PDOX->rowDie($query, $arr);
        return $context["main_id"];
    }

    function createMain($userId, $context_id, $link_id, $current_time)
    {
        $query = "INSERT INTO {$this->p}pp_main (user_id, context_id, link_id, modified) VALUES (:userId, :context_id, :link_id, :currentTime);";
        $arr = array(':userId' => $userId, ':context_id' => $context_id, ':link_id' => $link_id, ":currentTime" => $current_time);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function setupMain($main_id, $preText, $postText, $wrapText, $waitSec, $current_time) {
        $query = "UPDATE {$this->p}pp_main SET pre_question = :preText, post_question = :postText, wrap_question = :wrapText, wait_seconds = :waitSec, modified = :currentTime WHERE main_id = :mainId";
        $arr = array(
            ":preText" => $preText,
            ":postText" => $postText,
            ":wrapText" => $wrapText,
            ":waitSec" => $waitSec,
            ":currentTime" => $current_time,
            ":mainId" => $main_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function hasSetupMain($main_id) {
        $query = "SELECT pre_question FROM {$this->p}pp_main WHERE main_id = :mainId";
        $arr = array(':mainId' => $main_id);
        $preQuestionText = $this->PDOX->rowDie($query, $arr)["pre_question"];
        return (isset($preQuestionText) && trim($preQuestionText) !== '');
    }

    function hasSeenSplash($main_id) {
        $query = "SELECT seen_splash FROM {$this->p}pp_main WHERE main_id = :mainId";
        $arr = array(':mainId' => $main_id);
        return $this->PDOX->rowDie($query, $arr)["seen_splash"];
    }

    function markAsSeen($main_id) {
        $query = "UPDATE {$this->p}pp_main set seen_splash = 1 WHERE main_id = :mainId;";
        $arr = array(':mainId' => $main_id);
        $this->PDOX->queryDie($query, $arr);
    }

    function getMainTitle($main_id) {
        $query = "SELECT title FROM {$this->p}pp_main WHERE main_id = :mainId";
        $arr = array(':mainId' => $main_id);
        return $this->PDOX->rowDie($query, $arr)["title"];
    }

    function updateMainTitle($main_id, $title, $current_time) {
        $query = "UPDATE {$this->p}pp_main set title = :title, modified = :currentTime WHERE main_id = :mainId;";
        $arr = array(':title' => $title, ':currentTime' => $current_time, ':mainId' => $main_id);
        $this->PDOX->queryDie($query, $arr);
    }

    function getMainInfo($main_id) {
        $query = "SELECT pre_question, post_question, wrap_question, wait_seconds FROM {$this->p}pp_main WHERE main_id = :mainId";
        $arr = array(':mainId' => $main_id);
        return $this->PDOX->rowDie($query, $arr);
    }

    function updatePreQuestion($main_id, $pre_text, $current_time) {
        $query = "UPDATE {$this->p}pp_main SET pre_question = :preText, modified = :currentTime WHERE main_id = :mainId";
        $arr = array(
            ":preText" => $pre_text,
            ":currentTime" => $current_time,
            ":mainId" => $main_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function updatePostQuestion($main_id, $post_text, $current_time) {
        $query = "UPDATE {$this->p}pp_main SET post_question = :postText, modified = :currentTime WHERE main_id = :mainId";
        $arr = array(
            ":postText" => $post_text,
            ":currentTime" => $current_time,
            ":mainId" => $main_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function updateWrapQuestion($main_id, $wrap_text, $current_time) {
        $query = "UPDATE {$this->p}pp_main SET wrap_question = :wrapText, modified = :currentTime WHERE main_id = :mainId";
        $arr = array(
            ":wrapText" => $wrap_text,
            ":currentTime" => $current_time,
            ":mainId" => $main_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function updateWaitTime($main_id, $wait_time, $current_time) {
        $query = "UPDATE {$this->p}pp_main SET wait_seconds = :waitTime, modified = :currentTime WHERE main_id = :mainId";
        $arr = array(
            ":waitTime" => $wait_time,
            ":currentTime" => $current_time,
            ":mainId" => $main_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function getQuestion($main_id)
    {
        $query = "SELECT * FROM {$this->p}pp_question WHERE main_id = :main_id;";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->rowDie($query, $arr);
    }

    function deleteQuestion($question_id)
    {
        $query = "DELETE FROM {$this->p}pp_question WHERE question_id = :question_id;";
        $arr = array(':question_id' => $question_id);
        $this->PDOX->queryDie($query, $arr);
    }

    function editTitle($main_id, $question_title)
    {
        $query = "UPDATE {$this->p}pp_question set question_title = :question_title where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':question_title' => $question_title);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }
    function editPreQuestion($main_id, $pre_question)
    {
        $query = "UPDATE {$this->p}pp_question set pre_question = :pre_question where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':pre_question' => $pre_question);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }
    function editPostQuestion($main_id, $post_question)
    {
        $query = "UPDATE {$this->p}pp_question set post_question = :post_question where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':post_question' => $post_question);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }
    function editWrapUpText($main_id, $wrap_up_text)
    {
        $query = "UPDATE {$this->p}pp_question set wrap_up_text = :wrap_up_text where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':wrap_up_text' => $wrap_up_text);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function getStudentAnswers($question_id, $user_id)
    {
        $query = "SELECT * FROM {$this->p}pp_answer WHERE question_id = :question_id AND user_id = :user_id;";
        $arr = array(':question_id' => $question_id, ':user_id' => $user_id);
        return $this->PDOX->rowDie($query, $arr);
    }

    function answerPreQuestion($user_id, $question_ID, $pre_answer)
    {
        $query = "INSERT INTO {$this->p}pp_answer (user_id, question_id, pre_answer, pre_modified) VALUES (:user_id, :question_id, :pre_answer, now());";
        $arr = array(':user_id' => $user_id, ':question_id' => $question_ID, ':pre_answer' => $pre_answer);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function answerPostQuestion($user_id, $question_ID, $post_answer)
    {
        $query = "UPDATE {$this->p}pp_answer set post_answer = :post_answer, post_modified = now() where user_id = :user_id AND question_ID = :question_ID;";
        $arr = array(':user_id' => $user_id, ':question_ID' => $question_ID, ':post_answer' => $post_answer);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function answerWrapUpText($user_id, $question_ID, $wrap_up_answer)
    {
        $query = "UPDATE {$this->p}pp_answer set wrap_up_answer = :wrap_up_answer, wrap_up_modified = now() where user_id = :user_id AND question_ID = :question_ID;";
        $arr = array(':user_id' => $user_id, ':question_ID' => $question_ID, ':wrap_up_answer' => $wrap_up_answer);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function getAllStudentAnswers($question_id)
    {
        $query = "SELECT * FROM {$this->p}pp_answer WHERE question_id = :question_id;";
        $arr = array(':question_id' => $question_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function findDisplayName($user_id) {
        $query = "SELECT displayname FROM {$this->p}lti_user WHERE user_id = :user_id;";
        $arr = array(':user_id' => $user_id);
        $context = $this->PDOX->rowDie($query, $arr);
        return $context["displayname"];
    }

    function toggleWrapUp($main_id, $show_wrap_up_text){
        $query = "UPDATE {$this->p}pp_question set show_wrap_up_text = :show_wrap_up_text where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':show_wrap_up_text' => $show_wrap_up_text);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }
}
