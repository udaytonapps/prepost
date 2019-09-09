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

    function getOrCreateStudentResponseRecord($main_id, $user_id) {
        $responses = $this->getStudentResponses($main_id, $user_id);
        if (!$responses) {
            return $this->createStudentResponseRecord($main_id, $user_id);
        } else {
            return $responses;
        }
    }

    function getUsersWithAnswers($main_id) {
        $query = "SELECT DISTINCT user_id FROM {$this->p}pp_response WHERE main_id = :main_id AND pre_answer is not null AND pre_answer != '';";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function getMostRecentAnswerDate($main_id, $user_id) {
        $query = "SELECT pre_modified, post_modified, wrap_modified FROM {$this->p}pp_response WHERE user_id = :user_id AND main_id = :main_id;";
        $arr = array(':user_id' => $user_id, ':main_id' => $main_id);
        $dates = $this->PDOX->rowDie($query, $arr);
        if ($dates["wrap_modified"] && $dates["wrap_modified"] !== '') {
            return $dates["wrap_modified"];
        } else if ($dates["post_modified"] && $dates["post_modified"] !== '') {
            return $dates["post_modified"];
        } else {
            return $dates["pre_modified"];
        }
    }

    function getStudentResponses($main_id, $user_id) {
        $query = "SELECT * FROM {$this->p}pp_response WHERE main_id = :main_id AND user_id = :user_id;";
        $arr = array(':main_id' => $main_id, ':user_id' => $user_id);
        return $this->PDOX->rowDie($query, $arr);
    }

    function getPreResponses($main_id) {
        $query = "SELECT user_id, pre_answer, pre_modified FROM {$this->p}pp_response WHERE main_id = :main_id AND pre_answer is not null AND pre_answer != '' ORDER BY pre_modified desc";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function getPostResponses($main_id) {
        $query = "SELECT user_id, post_answer, post_modified FROM {$this->p}pp_response WHERE main_id = :main_id AND post_answer is not null AND post_answer != '' ORDER BY post_modified desc";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function getWrapResponses($main_id) {
        $query = "SELECT user_id, wrap_answer, wrap_modified FROM {$this->p}pp_response WHERE main_id = :main_id AND wrap_answer is not null AND wrap_answer != '' ORDER BY wrap_modified desc";
        $arr = array(':main_id' => $main_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function createStudentResponseRecord($main_id, $user_id) {
        $query = "INSERT INTO {$this->p}pp_response (main_id, user_id) VALUES (:main_id, :user_id);";
        $arr = array(':main_id' => $main_id, ':user_id' => $user_id);
        $this->PDOX->queryDie($query, $arr);
        return $this->getStudentResponses($main_id, $user_id);
    }

    function deleteResponseRecord($main_id, $user_id) {
        $query = "DELETE FROM {$this->p}pp_response WHERE main_id = :main_id AND user_id = :user_id";
        $arr = array(':main_id' => $main_id, ':user_id' => $user_id);
        $this->PDOX->queryDie($query, $arr);
    }

    function updatePreResponse($response_id, $pre_answer, $pre_modified) {
        $query = "UPDATE {$this->p}pp_response SET pre_answer = :pre_answer, pre_modified = :pre_modified WHERE response_id = :response_id";
        $arr = array(
            ":pre_answer" => $pre_answer,
            ":pre_modified" => $pre_modified,
            ":response_id" => $response_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function updatePostResponse($response_id, $post_answer, $post_modified) {
        $query = "UPDATE {$this->p}pp_response SET post_answer = :post_answer, post_modified = :post_modified WHERE response_id = :response_id";
        $arr = array(
            ":post_answer" => $post_answer,
            ":post_modified" => $post_modified,
            ":response_id" => $response_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function updateWrapResponse($response_id, $wrap_answer, $wrap_modified) {
        $query = "UPDATE {$this->p}pp_response SET wrap_answer = :wrap_answer, wrap_modified = :wrap_modified WHERE response_id = :response_id";
        $arr = array(
            ":wrap_answer" => $wrap_answer,
            ":wrap_modified" => $wrap_modified,
            ":response_id" => $response_id
        );
        $this->PDOX->queryDie($query, $arr);
    }

    function findEmail($user_id) {
        $query = "SELECT email FROM {$this->p}lti_user WHERE user_id = :user_id;";
        $arr = array(':user_id' => $user_id);
        $context = $this->PDOX->rowDie($query, $arr);
        return $context["email"];
    }

    function findDisplayName($user_id) {
        $query = "SELECT displayname FROM {$this->p}lti_user WHERE user_id = :user_id;";
        $arr = array(':user_id' => $user_id);
        $context = $this->PDOX->rowDie($query, $arr);
        return $context["displayname"];
    }

    function findInstructors($context_id) {
        $query = "SELECT user_id FROM {$this->p}lti_membership WHERE context_id = :context_id AND role = '1000';";
        $arr = array(':context_id' => $context_id);
        return $this->PDOX->allRowsDie($query, $arr);
    }

    function isUserInstructor($context_id, $user_id) {
        $query = "SELECT role FROM {$this->p}lti_membership WHERE context_id = :context_id AND user_id = :user_id;";
        $arr = array(':context_id' => $context_id, ':user_id' => $user_id);
        $role = $this->PDOX->rowDie($query, $arr);
        return $role["role"] == '1000';
    }
}
