<?php
$pages = array( // All pages
  "pclient" => array( // New page
    "pagetitle" => "CSA Client",
    "menutitle" => _x( "CSA Client", "CSA Client Administration", "csa-client" ),
    "capability" => "manage_options",
    "slug" => "edit.php?post_type=client",
    "function" => "",
    "icon" => "data:image/svg+xml;base64," . base64_encode('<?xml version="1.0" encoding="utf-8"?>
      <!-- Generator: Adobe Illustrator 22.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
      <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
      <style type="text/css">
        .st0{fill:#3D7CC9;}
      </style>
      <polygon class="st0" points="485.7,0 485.7,500 12,0 "/>
      </svg>'),
    "position" => 999,
    "sections" => array()
  ),
  "plocation" => array( // New page
    "pagetitle" => "Manage Locations",
    "menutitle" => _x( "Manage Locations", "CSA Client Locations", "csa-client" ),
    "capability" => "manage_options",
    "parentslug" => "edit.php?post_type=client",
    "slug" => "csa-client-locations",
    "function" => array( "CSA_Client_Location", "csa_render_location_main" ),
    "icon" => "",
    "position" => 999,
    "sections" => array()
  ),
  "pmain" => array( // New page
    "pagetitle" => "Settings",
    "menutitle" => _x( "Settings", "CSA Client Settings", "csa-client" ),
    "capability" => "manage_options",
    "parentslug" => "edit.php?post_type=client",
    "slug" => "csa-client-settings",
    "function" => array( $this, "csa_admin_page" ),
    "icon" => "",
    "position" => "",
    "sections" => array( // All sections
      "spreferences" => array( // New section
        "id" => "csaclas-preferences",
        "title" => _x( "Client Preferences", "Client Preferences", "csa-client" ),
        "callback" => array( $this, "csa_admin_page_section" ),
        "fields" => array( // All fields
          "fcharactermask" => array( // New field
            "id" => "csa_field_admin_charactermask", // Copy to args/fid
            "title" => _x( "Character Mask", "Character Mask", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_charactermask", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "text",
              "ftooltip" => "The character used to mask numbers in pattern.",
              "attributes" => array(
                "class" => "csa-field-admin character-mask",
                "maxlength"=>"1"
              )
            ) // End field arguments
          )
        ) // End fields
      ) // End section
    ) // End sections
  )
); // End pages
?>
