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

    function getQuestionId($main_id)
    {
        $query = "SELECT question_id FROM {$this->p}pp_question WHERE main_id = :main_id;";
        $arr = array(':main_id' => $main_id);
        $context = $this->PDOX->rowDie($query, $arr);
        return $context["question_id"];
    }

    function createMain($userId, $context_id, $link_id)
    {
        $query = "INSERT INTO {$this->p}pp_main (user_id, context_id, link_id) VALUES (:userId, :context_id, :link_id);";
        $arr = array(':userId' => $userId, ':context_id' => $context_id, ':link_id' => $link_id);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function createQuestion($user_id, $main_id, $question, $wrap_up_text, $show_wrap_up_text)
    {
        $query = "INSERT INTO {$this->p}pp_question (main_id, created, created_by, modified, modified_by, question, wrap_up_text, show_wrap_up_text) VALUES (:main_id, now(), :created_by, now(), :modified_by, :question, :wrap_up_text, :show_wrap_up_text);";
        $arr = array(':main_id' => $main_id, ':created_by' => $user_id, ':modified_by' => $user_id, ':question' => $question, ':wrap_up_text' => $wrap_up_text, ':show_wrap_up_text' => $show_wrap_up_text);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    //Modified for testing currently. Will use question_id later
    function deleteQuestion($main_id) {
        $query = "DELETE FROM {$this->p}pp_question WHERE main_id = :main_id;";
        $arr = array(':main_id' => $main_id);
        $this->PDOX->queryDie($query, $arr);
    }
}