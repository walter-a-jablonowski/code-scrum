<?php

require_once 'config.php';


if( ! SETUP_DONE )  exit('Please edit config first');

if( isset($_GET['refresh'] ))
  $grouped = require('refresh.php');
else
{
  if( ! file_exists('cache.json') )
    $grouped = require('refresh.php');
  else
    $grouped = json_decode( file_get_contents('cache.json'), true);
}


?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task list</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>

  <h3>Tasks</h3>

  <a href="index.php?refresh">refresh</a>

  <br>

  <table cellspacing="0">
    <tr>
      <td>Tag</td>
      <td>Prio</td>
      <td>Name</td>
      <td>File</td>
      <td>Line</td>
    </tr>

    <?php foreach($grouped as $log => $main): ?>

      <tr>
        <td class="log-header" colspan="5"><?= $log ?></td>
      </tr>

      <?php foreach($main as $name => $cat): ?>
      
        <?php if( isset($cat['MAIN'])): ?>
          <tbody onclick="collapse(this)">
            <tr>
              <td class="main-task" colspan="5">
                <?= $cat['MAIN']['prio'] ?>
                <?= $cat['MAIN']['name'] ?>
                (<?= basename($cat['MAIN']['file']) ?>)
              </td>
            </tr>
          </tbody>
        <?php endif; ?>
        
        <tbody<?= append( isset($cat['MAIN']), 'style', 'display: none;') ?>>

          <?php foreach($cat['SUB'] as $task):

            $task['tag'] = str_replace($log  . TAG_DELIMITER, '', $task['tag']);  // TASK: could ovewrite multiple occurences
            $task['tag'] = str_replace($name, '', $task['tag']);
          ?>

            <tr>
              <td><?= $task['tag'] ?></td>
              <td><?= $task['prio'] ?></td>
              <td><?= $task['name'] ?></td>
              <td title="<?= $task['file'] ?>"><?= basename($task['file']) ?></td>
              <td><?= $task['line'] ?></td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </table>

  <script>
    function collapse(e)
    {
      e = e.nextElementSibling;

      if( e.style.display == 'none')
        e.style.display = 'table-row-group';
      else
        e.style.display = 'none';
    }
  </script>

</body>
</html><?php

// Helper

function append( $condition, $att, $val )
{
  if( $condition )
    return " $att=\"$val\"";
  else
    return '';
}

?>