<?php

/*@
Scans files recursively and delivers tasks based on
a syntax given in $rg.

ARGS:
  string base_fld: start folder
  string type:     file type
  string rg:       regex
  array  fields:   field names (in keys) ad pos in rg result

DEV:
  Reserved: . \ + * ? [ ^ ] $ ( ) { } = ! < > | : - #
*/
function scan_entries( $base_fld, $type, $rg, $fields )  /*@*/
{
  $files = scan_all_fils( $base_fld, $type);

  $entries = [];

  foreach( $files as $file )
  {
    $s = file_get_contents($file);
    $s = trim( str_replace("\r\n", "\n", $s));
    $lines = explode("\n", $s);
    
    $i=0;
    foreach( $lines as $line )
    {
      $i++;

      if( preg_match_all($rg, $line, $e, PREG_SET_ORDER) )
      {
        foreach( $e as $entry )
        {
          $a = [];
          foreach( $fields as $name => $field )
            $a[$name] = $entry[ $fields[$name] ];

          $entries[] = array_merge( $a, [
            'file' => $file,
            'line' => $i
          ]);
        }
      }
    }
  }

  return $entries;
}

?>