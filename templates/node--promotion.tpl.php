<?php

?>

<div class="promotion" style="background-image:url('<?php print file_create_url($field_background_image[0]['uri']); ?>')">
  <?php if($field_indentation) : ?>
  <ul style="margin-left:<?php print $field_indentation[0]['value'] ?>px">
  <?php else: ?>
  <ul>
  <?php endif; ?>
    <!-- Fill container with JS -->
  </ul>
    <div class="element-hidden">
      <?php print render($content['field_links']); ?>
    </div>
</div>
