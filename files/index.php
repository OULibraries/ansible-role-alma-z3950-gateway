<?php
require_once 'config.php';

if (isset($_REQUEST['bib_id'])) {
    // Simple sanitizing of input
    $bib_id = preg_replace("/[^a-zA-Z0-9 ]+/", "", $_REQUEST['bib_id']);
    header('Content-Type: text/xml');
    header('Content-Disposition: inline; filename="'.$bib_id.'.xml";');
    $bib_id='@attr 1=12 ' . $bib_id;

    // The backend server can be unreliable, so we'll try connecting multiple
    // times if we get an erroneous response.    
    $xml_string;
    $maxTries = 5;
    for ($try=1; $try<=$maxTries; $try++) {
      $id = yaz_connect($target);
      yaz_syntax($id, "usmarc");
      yaz_range($id, 1, 1);
      $host_options = array(
          "timeout" => "10",
      );
      yaz_search($id, "rpn", $bib_id);
      yaz_wait($host_options);
      $error = yaz_error($id);
        
if (empty($error)) {
   // Successful Z39.50 Connection
            $rec = yaz_record($id, 1, 'xml');
            if (!empty($rec)) {
                // Successul record retrieval
                http_response_code(200);
                $doc = new DOMDocument();
               
		$rec_clean = mb_convert_encoding($rec, 'UTF-8', 'UTF-8');
                
                $doc->loadXML($rec_clean);
                $doc->formatOutput = true;
                $xml_string = $doc->saveXML();
                break;
            } else {
                // No record
                http_response_code(404);
                $errordoc = new DOMDocument();
                $title = $errordoc->createElement('title');
                $title = $errordoc->appendChild($title);
                $text = $errordoc->createTextNode('Not Found');
                $text = $title->appendChild($text);
                $xml_string = $errordoc->saveXML();
            }
       } else {
            // Z39.50 errors
            http_response_code(500);
            // Give the backend server a minute
            sleep(5);
            $errordoc = new DOMDocument();
            $title = $errordoc->createElement('title');
            $title = $errordoc->appendChild($title);
            $text = $errordoc->createTextNode($error);
            $text = $title->appendChild($text);
	    $xml_string = $errordoc->saveXML();
       }
    }
    // print whatever we've got!
    echo $xml_string;
}
?>
