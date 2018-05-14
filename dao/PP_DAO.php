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

    function createQuestion($user_id, $main_id, $question_title, $question)
    {
        $query = "INSERT INTO {$this->p}pp_question (main_id, created, created_by, modified, modified_by, question_title, pre_question, post_question) VALUES (:main_id, now(), :created_by, now(), :modified_by, :question_title, :question, :question);";
        $arr = array(':main_id' => $main_id, ':created_by' => $user_id, ':modified_by' => $user_id, ':question_title' => $question_title, ':question' => $question);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }

    function getQuestion($main_id)
    {
        $query = "SELECT * FROM {$this->p}pp_question WHERE main_id = :main_id;";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->rowDie($query, $arr);
    }

    //Modified for testing currently. Will use question_id later
    function deleteQuestion($main_id) {
        $query = "DELETE FROM {$this->p}pp_question WHERE main_id = :main_id;";
        $arr = array(':main_id' => $main_id);
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
    function editWrapUpText($main_id, $wrap_up_text, $show_wrap_up_text)
    {
        $query = "UPDATE {$this->p}pp_question set wrap_up_text = :wrap_up_text, show_wrap_up_text = :show_wrap_up_text where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':wrap_up_text' => $wrap_up_text, ':show_wrap_up_text' => $show_wrap_up_text);
        $this->PDOX->queryDie($query, $arr);
        return $this->PDOX->lastInsertId();
    }
}