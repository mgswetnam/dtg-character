<?php
$metaboxes = array( //Metaboxes
  "clientdetails" => array(
    "mbid" => "csa_client_details",
    "mbtitle" => "Client Details",
    "mbscreen" => "client", //string or array of post types
    "mbcontext" => "normal", //normal, side, advanced
    "mbpriority" => "default", //high, low, default
    "fields" => array( //Fields
      "flegalname" => array(
        "fid" => "csa_field_custom_legalname",
        "ftype" => "input",
        "fsubtype" => "text",
        "flabel" => "Legal Name",
        "fdefault" => "",
        "fwrapclass" => "third",
        "attributes" => array(
          "class" => "csa_custom_field legalname",
        )
      ),
      "fname" => array(
        "fid" => "csa_field_custom_name",
        "ftype" => "input",
        "fsubtype" => "text",
        "flabel" => "Company Name",
        "fdefault" => "",
        "fwrapclass" => "third",
        "attributes" => array(
          "class" => "csa_custom_field name",
        )
      ),
      "fshortname" => array(
        "fid" => "csa_field_custom_shortname",
        "ftype" => "input",
        "fsubtype" => "text",
        "flabel" => "Company Short Name",
        "fdefault" => "",
        "fwrapclass" => "third",
        "attributes" => array(
          "class" => "csa_custom_field shortname",
        )
      ),
      "ffounded" => array(
        "fid" => "csa_field_custom_founded",
        "ftype" => "input",
        "fsubtype" => "date",
        "flabel" => "Date Founded",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field founded",
        )
      ),
      "fdepartments" => array(
        "fid" => "csa_field_custom_departments",
        "ftype" => "textarea",
        "fsubtype" => "text",
        "flabel" => "Departments (one per line)",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field departments",
          "rows" => "6"
        )
      ),
      "fareas" => array(
        "fid" => "csa_field_custom_areas",
        "ftype" => "textarea",
        "fsubtype" => "text",
        "flabel" => "Areas Served (one per line)",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field areas",
          "rows" => "6"
        )
      ),
      "flicences" => array(
        "fid" => "csa_field_custom_licenses",
        "ftype" => "textarea",
        "fsubtype" => "text",
        "flabel" => "Licenses (one per line; seperate name and number with colon (:) )",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field licenses",
          "rows" => "6"
        )
      ),
      "findustry" => array(
        "fid" => "csa_field_custom_industry",
        "ftype" => "input",
        "fsubtype" => "checkbox",
        "flabel" => "Industries (Check all that apply)",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field industry",
          "options" => array(
            "air quality" => "Air Quality",
            "automation" => "Automation",
            "clothing retail" => "Clothing Retail",
            "cooling" => "Cooling",
            "electrical" => "Electrical",
            "flooring" => "Flooring",
            "heating" => "Heating",
            "landscaping" => "Landscaping",
            "home remodeling" => "Home Remodeling",
            "moving" => "Moving",
            "pest control" => "Pest Control",
            "plumbing" => "Plumbing",
            "security" => "Security",
            "storage" => "Storage",
            "windows" => "Windows"
          )
        )
      ),
      "fdaysopen" => array(
        "fid" => "csa_field_custom_businesshours",
        "ftype" => "hours",
        "fsubtype" => "text",
        "flabel" => "Hours",
        "fdefault" => "",
        "fwrapclass" => "half",
        "attributes" => array(
          "class" => "csa_custom_field businesshours"
        )
      ),
      "fprimaryclient" => array(
        "fid" => "csa_field_custom_primaryclient",
        "ftype" => "input",
        "fsubtype" => "radio",
        "flabel" => "Set client as primary",
        "fdefault" => "no",
        "attributes" => array(
          "class" => "csa_custom_field primaryclient",
          "options" => array(
            "yes" => "Yes",
            "no" => "No"
          )
        )
      ),
    )
  )
);
?>
