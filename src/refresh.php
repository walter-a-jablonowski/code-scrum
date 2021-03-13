<?php

// file returns

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'lib/file_entries.php';

// TASK: sorting

/*
usort($tasks, function($a, $b) {
  $prio1 = ['MUST' => 3, 'SHOULD' => 2, 'CAN' => 1 ][ $a['prio'] ];
  $prio2 = ['MUST' => 3, 'SHOULD' => 2, 'CAN' => 1 ][ $b['prio'] ];
  return ($prio1 > $prio2) ? -1 : 1;
});
*/

$grouped['Backlog'] = [];

// File tasks

$main = scan_all_fils( PROJ_FLD, 'yml');  // TASK: only tasks.yml files

foreach( $main as $file )
{
  $yml = Yaml::parse( file_get_contents($file));

  foreach( $yml as $task )
  {
    $task['file'] = $file;
    $task['line'] = '';
    $grouped[ $task['tag'] ][ $task['name'] ]['MAIN'] = $task;
    $grouped[ $task['tag'] ][ $task['name'] ]['SUB'] = [];
  }
}

// In file tasks

$tasks = scan_entries( PROJ_FLD, TYPE,

  '/\/\/\s*TASK\:\s*(\[(.+)\])?\s*(MUST|SHOULD|CAN)?\s*(.+)/', [

  'tag'  => 2,
  'prio' => 3,
  'name' => 4
]);

foreach( $tasks as $task )
{
  if( $tags = $task['tag'] )
  {
    $tags = explode( TAG_DELIMITER, $tags);
    $tags[0] = $tags[0] === 'B'  ?  'Backlog'  :  strval($tags[0]);
    
    if( count($tags) == 1 )
      $grouped[ $tags[0] ]['Misc']['SUB'][] = $task;
    elseif( count($tags) > 1 )
      $grouped[ $tags[0] ][ $tags[1] ]['SUB'][] = $task;
  }
  else
    $grouped['Backlog']['Misc']['SUB'][] = $task;
}

// var_dump($grouped);
// exit();


file_put_contents('cache.json', json_encode( $grouped, JSON_PRETTY_PRINT));
return $grouped;

?>