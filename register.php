<?php

$REGISTER_LTI2 = array(
    "name" => "Pre/Post Reflection", // Name of the tool
    "FontAwesome" => "fa-history", // Icon for the tool
    "short_name" => "Pre/Post",
    "description" => "This tool allows an instructor to create a question for a student to answer before and after an activity.", // Tool description
    "messages" => array("launch"),
    "privacy_level" => "public",  // anonymous, name_only, public
    "license" => "Apache",
    "languages" => array(
        "English",
    ),
    "source_url" => "https://github.com/udaytonapps/prepost",
    // For now Tsugi tools delegate this to /lti/store
    "placements" => array(
        /*
        "course_navigation", "homework_submission",
        "course_home_submission", "editor_button",
        "link_selection", "migration_selection", "resource_selection",
        "tool_configuration", "user_navigation"
        */
    ),
    "screen_shots" => array(
    )
);
