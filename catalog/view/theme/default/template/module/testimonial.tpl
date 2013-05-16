<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content testimonial">
  <?php if ($testimonials) { ?>
  <?php foreach ($testimonials as $testimonial) { ?>
    <?php echo $testimonial['description']; ?><br />
    <p class="right">
      <img src="catalog/view/theme/default/image/stars-<?php echo $testimonial['rating'] . '.png'; ?>" alt="<?php echo $testimonial['rating']; ?>" /><br />
      <?php if ($testimonial['url']) { ?>
      <a href="<?php echo $testimonial['url']; ?>" target="_blank"><?php echo $testimonial['name']; ?></a>
      <?php } else { ?>
      <?php echo $testimonial['name']; ?>
      <?php } ?>
      <?php if ($testimonial['location']) { ?>
      - <?php echo $testimonial['location']; ?>
      <?php } ?>
      </p>
      <hr />
  <?php } ?>
  <?php } else { ?>
    <div class="content"><?php echo $text_no_results; ?></div>
    <hr />
  <?php } ?>
    <a class="button" href="<?php echo $more; ?>"><span><?php echo $text_more; ?></span></a>
    <a class="button right" href="<?php echo $add; ?>"><span><?php echo $text_add; ?></span></a>
  </div>
</div>