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
      <h1><img src="view/image/staff.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a></td>
              <td class="left"><a href="<?php echo $sort_lastname; ?>"><?php echo $column_name; ?></a></td>
              <td class="left"><a href="<?php echo $sort_birthday; ?>"><?php echo $column_birthday; ?></a></td>
              <td class="left"><a href="<?php echo $sort_salary; ?>"><?php echo $column_salary; ?></a></td>
              <td class="left"><?php echo $column_department; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" style="width: 70px;" /></td>
              <td><input type="text" name="filter_fullname" value="<?php echo $filter_fullname; ?>" /></td>
              <td>
              <select name="filter_day">
                <option value="0"><?php echo $text_day; ?></option>
                <?php for ($i=1; $i <= 31; $i++) { ?>
                  <option <?php if ($filter_day == $i){ ?>selected="selected"<?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <select name="filter_month">
                <option value="0"><?php echo $text_month; ?></option>
                <?php for ($i=1; $i <= 12; $i++) { ?>
                  <option <?php if ($filter_month == $i){ ?>selected="selected"<?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <input type="text" name="filter_year" value="<?php echo $filter_year; ?>" style="width: 50px;" /></td>
              <td><input type="text" name="filter_salary" value="<?php echo $filter_salary; ?>" style="width: 70px;" /></td>
              <td><select name="filter_department_id">
                <option value="0"><?php echo $text_select; ?></option>
                <?php foreach ($departments as $department) {?>
                <option <?php if ($filter_department_id == $department['id']) { ?>selected="selected"<?php } ?> value="<?php echo $department['id'] ?>"><?php echo $department['name'] ?></option>
                <?php } ?>
              </select></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($staffs) { ?>
            <?php foreach ($staffs as $staff) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($staff['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $staff['staff_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $staff['staff_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $staff['code']; ?></td>
              <td class="left"><?php echo $staff['name']; ?></td>
              <td class="left"><?php echo $staff['birthday']; ?></td>
              <td class="left"><?php echo $staff['salary']; ?></td>
              <td class="left"><?php echo $staff['department']; ?></td>
              <td class="right"><?php foreach ($staff['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
  url = 'index.php?route=staff/staff&token=<?php echo $token; ?>';
  
  var filter_code = $('input[name=\'filter_code\']').attr('value');
  
  if (filter_code) {
    url += '&filter_code=' + encodeURIComponent(filter_code);
  }
  
  var filter_fullname = $('input[name=\'filter_fullname\']').attr('value');
  
  if (filter_fullname) {
    url += '&filter_fullname=' + encodeURIComponent(filter_fullname);
  }
  
  var filter_day = $('select[name=\'filter_day\']').attr('value');
  
  if (filter_day != 0) {
    url += '&filter_day=' + encodeURIComponent(filter_day);
  }
  
  var filter_month = $('select[name=\'filter_month\']').attr('value');
  
  if (filter_month != 0) {
    url += '&filter_month=' + encodeURIComponent(filter_month);
  }
  
  var filter_year = $('input[name=\'filter_year\']').attr('value');
  
  if (filter_year) {
    url += '&filter_year=' + encodeURIComponent(filter_year);
  } 

  var filter_salary = $('input[name=\'filter_salary\']').attr('value');
  
  if (filter_salary) {
    url += '&filter_salary=' + encodeURIComponent(filter_salary);
  }

  var filter_department_id = $('select[name=\'filter_department_id\']').attr('value');
  
  if (filter_department_id != 0) {
    url += '&filter_department_id=' + encodeURIComponent(filter_department_id);
  }

  location = url;
}
//--></script> 
<?php echo $footer; ?>