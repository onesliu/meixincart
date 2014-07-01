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
              <td><span class="required">*</span> <?php echo $config_token; ?></td>
              <td><input type="text" name="weixin_token" value="<?php echo $weixin_token; ?>" size="40" />
                <?php if ($error_token) { ?>
                <span class="error"><?php echo $error_token; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $config_appid; ?></td>
              <td><input type="text" name="weixin_appid" value="<?php echo $weixin_appid; ?>" size="40" />
                <?php if ($error_appid) { ?>
                <span class="error"><?php echo $error_appid; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $config_appsecret; ?></td>
              <td><input type="text" name="weixin_appsecret" value="<?php echo $weixin_appsecret; ?>" size="40" />
                <?php if ($error_appsecret) { ?>
                <span class="error"><?php echo $error_appsecret; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $config_menu; ?></td>
              <td><textarea id="menudata" name="weixin_menu" row="40" cols="100" style="margin: 2px; width: 550px; height: 350px;"><?php echo $weixin_menu; ?></textarea><br/>
              <span class="buttons"><a onclick="create_menu();" class="button">创建菜单</a></span>
                <?php if ($error_appsecret) { ?>
                <span class="error"><?php echo $error_menu; ?></span>
                <?php } ?></td>
            </tr>
          </table>
       </form>
    </div>
  </div>
</div>
<script>
function create_menu() {
	$.ajax({
		url: 'index.php?route=weixin/menu_create&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(json) {
			alert(json.errmsg);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
</script>
<?php echo $footer; ?> 