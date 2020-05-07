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
      )
    )
  )
);
?>
