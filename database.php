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
    user_id           INTEGER NOT NULL,
    context_id        INTEGER NOT NULL,
	link_id           INTEGER NOT NULL,
	seen_splash       BOOL NOT NULL DEFAULT 0,
	title             VARCHAR(255) NULL,
	pre_question      TEXT NULL,
	post_question     TEXT NULL,
	wrap_question     TEXT NULL,
	wait_seconds      INTEGER NULL,
	modified          datetime NULL,
	
	UNIQUE(context_id, link_id),
    PRIMARY KEY(main_id)
	
) ENGINE = InnoDB DEFAULT CHARSET=utf8"),
    array( "{$CFG->dbprefix}pp_response",
        "create table {$CFG->dbprefix}pp_response (
    response_id       INTEGER NOT NULL AUTO_INCREMENT,
    user_id           INTEGER NOT NULL,
    main_id           INTEGER NOT NULL,
	pre_answer        TEXT NULL,
    pre_modified      datetime NULL,
    post_answer       TEXT NULL,
    post_modified     datetime NULL,
    wrap_answer    TEXT NULL,
    wrap_modified  datetime NULL,
    
    CONSTRAINT `{$CFG->dbprefix}pp_response_ibfk_1`
        FOREIGN KEY (`main_id`)
        REFERENCES `{$CFG->dbprefix}pp_main` (`main_id`)
        ON DELETE CASCADE,
    
    UNIQUE(user_id, main_id),
    PRIMARY KEY(response_id)
    
) ENGINE = InnoDB DEFAULT CHARSET=utf8")
);