<?php

if ($data->desc()) {
  echo '<p class="description">' . $data->desc() . '</p>';
}

if ($data->prop('data')) {
  foreach ($data->prop('data') as $v) {
    if (isset($v['desc'])) {
      echo '<p class="description">' . $v['desc'] . '</p>';
    }

    if (isset($v['code'])) {
      $ft = isset($v['ft']) ? $v['ft'] : $data->ft();
      $s  = $ft ? sprintf(" class='%s'", ('txt' == $ft) ? 'no-highlight' : $ft) : '';

      echo '<pre><code' . $s . '>' . h($v['code']) . '</code></pre>';
    }

    if (isset($v['html'])) {
      echo '<br>';
      echo '<code>' . $v['html'] . '</code>';
    }

    if (isset($v['out'])) {
      echo '<pre><code class="no-highlight out">' . h($v['out']) . '</code></pre>';
    }
  }
} elseif ($data->prop('html')) {
  echo '<br>';
  echo '<code>' . $data->prop('html') . '</code>';
} else {
  $s = (($data->ft()) ? sprintf(" class='%s'", ($data->ft() == 'txt') ? 'no-highlight' : $data->ft()) : '');
  echo '<pre><code' . $s . '>' . h($data->code()) . '</code></pre>';

  if ($data->out()) {
    echo '<pre><code class="no-highlight out">' . h($data->out()) . '</code></pre>';
  }
}
