<?php

// The SQL to uninstall this tool
$DATABASE_UNINSTALL = array(
    // Nothing upon uninstall
    // Records should probably kept in case of accidental uninstall
);

// The SQL to create the tables if they don't exist
$DATABASE_INSTALL = array(
    array( "{$CFG->dbprefix}pp_main",
        "create table {$CFG->dbprefix}pp_main (
    main_id           INTEGER NOT NULL AUTO_INCREMENT,
    user_id           INTEGER NULL,
    context_id        INTEGER NULL,
	link_id           INTEGER NOT NULL,
	
	UNIQUE(context_id, link_id),
    PRIMARY KEY(main_id)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8"),
    array( "{$CFG->dbprefix}pp_question",
        "create table {$CFG->dbprefix}pp_question (
    question_id       INTEGER NOT NULL AUTO_INCREMENT,
    main_id           INTEGER NOT NULL,
    created           datetime NULL,
    created_by        INTEGER NULL,
    modified          datetime NULL,
    modified_by       INTEGER NULL,
    question_title    TEXT NULL,
    pre_question      TEXT NULL,   
    post_question     TEXT NULL, 
    wrap_up_text      TEXT NULL,  
    show_wrap_up_text BOOLEAN NOT NULL DEFAULT FALSE, 
    
    CONSTRAINT `{$CFG->dbprefix}pp_question_ibfk_1`
        FOREIGN KEY (`main_id`)
        REFERENCES `{$CFG->dbprefix}pp_main` (`main_id`)
        ON UPDATE CASCADE,
        
    PRIMARY KEY(question_id)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8"),
    array( "{$CFG->dbprefix}pp_answer",
        "create table {$CFG->dbprefix}pp_answer (
    answer_id         INTEGER NOT NULL AUTO_INCREMENT,
    user_id           INTEGER NOT NULL,
    question_id       INTEGER NOT NULL,
	pre_answer        TEXT NULL,
    pre_modified      datetime NULL,
    post_answer       TEXT NULL,
    post_modified     datetime NULL,
    wrap_up_answer    TEXT NULL,
    wrap_up_modified  datetime NULL,
    
    CONSTRAINT `{$CFG->dbprefix}pp_answer_ibfk_1`
        FOREIGN KEY (`question_id`)
        REFERENCES `{$CFG->dbprefix}pp_question` (`question_id`)
        ON DELETE CASCADE,
    
    PRIMARY KEY(answer_id)
    
) ENGINE = InnoDB DEFAULT CHARSET=utf8")
);
