<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="middle">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="content">
    <b><span class="required">*</span> <?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <br />
    <?php if ($error_name) { ?>
    <span class="error"><?php echo $error_name; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_url; ?></b><br />
    <input type="text" name="url" value="<?php echo $url; ?>" />
    <br />
    <br />
    <b><?php echo $entry_location; ?></b><br />
    <input type="text" name="location" value="<?php echo $location; ?>" />
    <br />
    <br />
    <b><?php echo $entry_image; ?></b><br />
    <input type="text" name="image" value="<?php echo $image; ?>" size="50" />&nbsp;<a id="testimonial-image" class="button"><span><?php echo $button_upload; ?></span></a>
    <br />
    <br />
    <span class="required">*</span> <b><?php echo $entry_description; ?></b><br />
    <textarea name="description" cols="40" rows="10" style="width: 90%;"><?php echo $description; ?></textarea>
    <br />
    <?php if ($error_description) { ?>
    <span class="error"><?php echo $error_description; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $text_bad; ?></span>&nbsp;
    <input style="vertical-align: text-bottom; padding: 0; margin: 0;" type="radio" name="rating" value="1" />
    &nbsp;
    <input style="vertical-align: text-bottom; padding: 0; margin: 0;" type="radio" name="rating" value="2" />
    &nbsp;
    <input style="vertical-align: text-bottom; padding: 0; margin: 0;" type="radio" name="rating" value="3" />
    &nbsp;
    <input style="vertical-align: text-bottom; padding: 0; margin: 0;" type="radio" name="rating" value="4" />
    &nbsp;
    <input style="vertical-align: text-bottom; padding: 0; margin: 0;" type="radio" name="rating" value="5" />
    &nbsp; <span><?php echo $text_good; ?></span>
    <br />
    <br />
    <br />
    <b><span class="required">*</span> <?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
    <br />
    <img src="index.php?route=information/contact/captcha" alt="" />
    <?php if ($error_captcha) { ?>
    <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
    </div>
      <div class="buttons">
        <div class="right"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_submit; ?></span></a></div>
      </div>
    </form>
  </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<script type="text/javascript"><!--
new AjaxUpload('#testimonial-image', {
    action: 'index.php?route=testimonial/testimonial_form/upload',
    name: 'file',
    autoSubmit: true,
    responseType: 'json',
    onSubmit: function(file, extension) {
        $('#testimonial-image').after('<img src="catalog/view/theme/default/image/loading.gif" id="loading" style="padding-left: 5px;" />');
    },
    onComplete: function(file, json) {
        $('.error').remove();

        if (json['success']) {
            alert(json['success']);

            $('input[name=\'image\']').attr('value', json['file']);
        }

        if (json['error']) {
            $('#testimonial-image').after('<span class="error">' + json['error'] + '</span>');
        }

        $('#loading').remove();
    }
});
//--></script>
  <?php echo $footer; ?>