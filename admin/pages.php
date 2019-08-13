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
  "pemail" => array( // New page
    "pagetitle" => "Manage Email",
    "menutitle" => _x( "Manage Email", "CSA Client Email", "csa-client" ),
    "capability" => "manage_options",
    "parentslug" => "edit.php?post_type=client",
    "slug" => "csa-client-email",
    "function" => array( "CSA_Client_Email", "csa_render_email_main" ),
    "icon" => "",
    "position" => 999,
    "sections" => array()
  ),
  "pphone" => array( // New page
    "pagetitle" => "Manage Phone Numbers",
    "menutitle" => _x( "Manage Phone Numbers", "CSA Client Phone Numbers", "csa-client" ),
    "capability" => "manage_options",
    "parentslug" => "edit.php?post_type=client",
    "slug" => "csa-client-phones",
    "function" => array( "CSA_Client_Phone", "csa_render_phone_main" ),
    "icon" => "",
    "position" => 999,
    "sections" => array()
  ),
  "pdni" => array( // New page
    "pagetitle" => "Manage DNI",
    "menutitle" => _x( "Manage DNI", "CSA Client DNI", "csa-client" ),
    "capability" => "manage_options",
    "parentslug" => "edit.php?post_type=client",
    "slug" => "csa-client-dni",
    "function" => array( "CSA_Client_DNI", "csa_render_dni_main" ),
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
          ),
          "fphonepattern" => array( // New field
            "id" => "csa_field_admin_phonepattern", // Copy to args/fid
            "title" => _x( "Phone Number Pattern", "Phone Number Pattern", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_phonepattern", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "text",
              "ftooltip" => "Using Xs in place of numbers, define the pattern in which to display phone numbers.",
              "attributes" => array(
                "class" => "csa-field-admin phone-pattern"
              )
            ) // End field arguments
          ),
          "fdnivariable" => array( // New field
            "id" => "csa_field_admin_dnivariable", // Copy to args/fid
            "title" => _x( "DNI Variable", "DNI Variable", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_dnivariable", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "text",
              "ftooltip" => "Define the variable name used to specify the DNI tag in the link's querystring.",
              "attributes" => array(
                "class" => "csa-field-admin dni-variable"
              )
            ) // End field arguments
          ),
          "fdnifallback" => array( // New field
            "id" => "csa_field_admin_dnifallback", // Copy to args/fid
            "title" => _x( "Emergency Fallback Number", "Emergency Fallback Number", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_dnifallback", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "text",
              "ftooltip" => "Emergency fallback number if nothing can be found for DNI.",
              "attributes" => array(
                "class" => "csa-field-admin dni-fallback"
              )
            ) // End field arguments
          ),
          "freferrerfallback" => array(
            "id" => "csa_field_admin_referrerfallback", // Copy to args/fid
            "title" => _x( "Referrer Fallback Numbers", "Referrer Fallback Numbers", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_referrerfallback",
              "ftype" => "keyval",
              "fsubtype" => array(
                "field1" => array(
                  "select" => array(
                    "angieslist.com" => "Angie's List",
                    "bing.com" => "Bing",
                    "facebook.com" => "Facebook",
                    "google.com" => "Google",
                    "instagram.com" => "Instagram",
                    "twitter.com" => "Twitter",
                    "yellowpages.com" => "Yellow Pages",
                    "yelp.com" => "Yelp",
                  )
                ),
                "field2" => array(
                  "input" => "text"
                )
              ),
              "ftooltip" => "Numbers to default to for specific referrers.",
              "attributes" => array(
                "class" => "csa-field-admin referrer-fallback"
              )
            ),
          ),
          "fsiteurl" => array( // New field
            "id" => "csa_field_admin_siteurl", // Copy to args/fid
            "title" => _x( "Site URL", "Site URL", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_siteurl", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "url",
              "ftooltip" => "For most sites this is the only URL, but for sites with multiple URLs this is the default or main URL.",
              "attributes" => array(
                "class" => "csa-field-admin site-url"
              )
            ) // End field arguments
          ),
          "falturls" => array( // New field
            "id" => "csa_field_admin_alturls", // Copy to args/fid
            "title" => _x( "Alternate URLs", "Alternate URLs", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_alturls", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "url",
              "ftooltip" => "Other URLs that the site may be seen as.",
              "frepeat" => "true",
              "attributes" => array(
                "class" => "csa-field-admin alternate-urls"
              )
            ) // End field arguments
          ),
          "faltdefault" => array( // New field
            "id" => "csa_field_admin_altdefault", // Copy to args/fid
            "title" => _x( "Default Alternate URL's DNI to parent number?", "Default Alternate URL's DNI to parent number?", "csa-client" ),
            "callback" => array( $this, "csa_admin_page_section_field" ),
            "args" => array(
              "fid" => "csa_field_admin_altdefault", // Must be the same as "id"
              "ftype" => "input",
              "fsubtype" => "checkbox",
              "ftooltip" => "If the site has multiple URLs, should the alternate URL use the parent phone number's DNI? Leave blank if there are no alternate URLs",
              "attributes" => array(
                "class" => "csa-field-admin altdefault",
                "options" => array(
                  "yes" => "Yes"
                )
              )
            ) // End field arguments
          ),
        ) // End fields
      ) // End section
    ) // End sections
  )
); // End pages
?>
