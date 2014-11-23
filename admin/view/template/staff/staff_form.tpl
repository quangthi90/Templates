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
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-salary"><?php echo $tab_salary; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <table class="form">
          	<tr>
              <td><?php echo $entry_firstname; ?></td>
              <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_middlename; ?></td>
              <td><input type="text" name="middlename" value="<?php echo $middlename; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
              <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" size="100" />
              <?php if ($error_lastname) { ?>
                <span class="error"><?php echo $error_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_code; ?></td>
              <td><input type="text" name="code" value="<?php echo $code; ?>" size="100" />
              <?php if ($error_code) { ?>
                <span class="error"><?php echo $error_code; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td valign="top"><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                  <br />
                  <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_birthday; ?></td>
              <td><input class="input-medium date" style="width: 250px;" type="text" name="birthday" value="<?php echo $birthday; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_sex; ?></td>
              <td><select name="sex">
                  <option value="0" <?php if ($sex == 0) { ?>selected="selected"<?php } ?>><?php echo $text_female; ?></option>
                  <option value="1" <?php if ($sex == 1) { ?>selected="selected"<?php } ?>><?php echo $text_male; ?></option>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_address; ?></td>
              <td><input type="text" name="address" value="<?php echo $address; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_department; ?></td>
              <td><select name="department_id">
                  <?php foreach ($departments as $department) { ?>
                  <option value="<?php echo $department['id'] ?>" <?php if ($department['id'] == $department_id) { ?>selected="selected"<?php } ?>><?php echo $department['name']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <div id="tab-salary">
          <table class="form">
            <tr>
              <td><?php echo $entry_salary; ?></td>
              <td><input type="text" name="salary" value="<?php echo $salary; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_salary_trial; ?></td>
              <td><input type="text" name="salary_trial" value="<?php echo $salary_trial; ?>" size="100" /></td>
            </tr>
            <?php foreach ($salaries as $salary) { ?>
            <tr>
              <td><?php echo $salary['name']; ?>:</td>
              <td><input type="text" name="salaries[<?php echo $salary['id']; ?>]" value="<?php echo $salary['value']; ?>" size="100" /></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_identity_card; ?></td>
              <td><input type="text" name="identity_card" value="<?php echo $identity_card; ?>" size="100" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_birthplace; ?></td>
              <td><select name="birthplace_id">
              <?php foreach ($cities as $city) { ?>
                <option <?php if ($city['id'] == $birthplace_id) { ?>selected="selected"<?php } ?> value="<?php echo $city['id'] ?>"><?php echo $city['name'] ?></option>
              <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_folk; ?></td>
              <td><select name="folk_id">
                  <?php foreach ($folks as $folk) { ?>
                  <option value="<?php echo $folk['id'] ?>" <?php if ($folk['id'] == $folk_id) { ?>selected="selected"<?php } ?>><?php echo $folk['name']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_religion; ?></td>
              <td><select name="religion_id">
                  <?php foreach ($religions as $religion) { ?>
                  <option value="<?php echo $religion['id'] ?>" <?php if ($religion['id'] == $religion_id) { ?>selected="selected"<?php } ?>><?php echo $religion['name']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_marital; ?></td>
              <td><select name="marital">
                  <option value="1" <?php if ($marital == 1) { ?>selected="selected"<?php } ?>><?php echo $text_single; ?></option>
                  <option value="0" <?php if ($marital == 0) { ?>selected="selected"<?php } ?>><?php echo $text_married; ?></option>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_valid_from; ?></td>
              <td><input class="input-medium date" style="width: 250px;" type="text" name="valid_from" value="<?php echo $valid_from; ?>" size="100" /></td>
            </tr>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();
//--></script> 
<script type="text/javascript"><!--//
    $('.date').datepicker({ appendText: " (yyyy-mm-dd)", dateFormat: "yy-mm-dd" });
//--></script>
<?php echo $footer; ?>