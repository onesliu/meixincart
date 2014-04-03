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
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <?php echo $weixin_token; ?></td>
              <td><input type="text" name="config_token" value="<?php echo $config_token; ?>" size="40" />
                <?php if ($error_token) { ?>
                <span class="error"><?php echo $error_token; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $weixin_appid; ?></td>
              <td><input type="text" name="config_appid" value="<?php echo $config_appid; ?>" size="40" />
                <?php if ($error_appid) { ?>
                <span class="error"><?php echo $error_appid; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $weixin_appsecret; ?></td>
              <td><input type="text" name="config_appsecret" value="<?php echo $config_appsecret; ?>" size="40" />
                <?php if ($error_appsecret) { ?>
                <span class="error"><?php echo $error_appsecret; ?></span>
                <?php } ?></td>
            </tr>
          </table>
       </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 