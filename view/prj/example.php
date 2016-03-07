<?php
echo '<div id="usage"><div class="num">';

if (!is_example_path(path())) {
  echo '<a href="' . $data->url() . '" name="example_' . $data->id() . '">';
}

echo '<span>№</span>' . $data->id();

if (!is_example_path(path())) {
  echo '</a>';
}

echo '</div>';

echo '<div class="usage_example">';
echo $data->content();
echo '</div></div>';
?>

