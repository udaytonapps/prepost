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
    function editWrapUpText($main_id, $wrap_up_text, $show_wrap_up_text)
    {
        $query = "UPDATE {$this->p}pp_question set wrap_up_text = :wrap_up_text, show_wrap_up_text = :show_wrap_up_text where main_id = :main_id;";
        $arr = array(':main_id' => $main_id, ':wrap_up_text' => $wrap_up_text, ':show_wrap_up_text' => $show_wrap_up_text);
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
}
