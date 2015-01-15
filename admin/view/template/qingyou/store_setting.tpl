<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
	  <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $label_minum_order; ?></td>
              <td><input type="text" name="minum_order" value="<?php echo $minum_order; ?>" size="10" />
                <?php if ($error_minum_order) { ?>
                <span class="error"><?php echo $error_minum_order; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $label_help_interval; ?></td>
              <td><input type="text" name="help_interval" value="<?php echo $help_interval; ?>" size="10" />
                <?php if ($error_help_interval) { ?>
                <span class="error"><?php echo $error_help_interval; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $label_shipping_interval; ?></td>
              <td><input type="text" name="shipping_interval" value="<?php echo $shipping_interval; ?>" size="10" />
                <?php if ($error_shipping_interval) { ?>
                <span class="error"><?php echo $error_shipping_interval; ?></span>
                <?php } ?></td>
            </tr>
          </table>
       </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 