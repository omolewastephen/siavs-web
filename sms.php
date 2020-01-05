<?php
require('init.php');
include 'template/header.php';
$sms = $db->single("SELECT * FROM message  ");
$id = $sms->id;
$ids = $_SESSION['sess_id'];
$admin = $db->single("SELECT * FROM admin WHERE id = '{$ids}' ");
if(isset($_POST['update'])){
  $arrival = clean($_POST['arrival']);
  $departure = clean($_POST['departure']);
  $sender = clean($_POST['sender']);
  $api_username = clean($_POST['api_username']);
  $api_password = clean($_POST['api_password']);

    $data = array(
      'arrival' => $arrival,
      'departure' => $departure,
      'Sender' => $sender,
      'api_username' => $api_username,
      'api_password' => $api_password
    );
    if($db->update('message',$data,$id)){
      $success = notification('Updated Successfully','success');
    }else{
      $error = notification('Error updating sms settings','danger');
    }

}
?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-12 col-lg-12">
        <h3 class="page-header pb-3">
          <span class="fa fa-envelope"></span> SMS SETTINGS
          <a href="home.php" class="btn btn-md btn-dark float-right"><i class="fa fa-home"></i> Home</a>
        </h3>
    </div>
  </div>
    <div class="row mt-2">
      <div class="col-md-6 col-lg-6">
        <?php if(!empty($error)){ echo $error; header('refresh: 2'); } ?>
        <?php if(!empty($success)){ echo $success; header('refresh: 2'); } ?>
        <form method="post">
           <div class="form-group">
            <label>Sender</label>
            <textarea name="sender" maxlength="11" class="form-control"><?php echo (!empty($sms->Sender))? trim($sms->Sender): " ";?></textarea>
            <span class="form-text text-muted">Max. length is 11</span>
          </div>
          <div class="form-group">
            <label>Edit Arrival Message</label>
            <textarea name="arrival" class="form-control"><?php echo (!empty($sms->arrival))? trim($sms->arrival): " ";?></textarea>
            <span class="form-text text-muted">Place "_PARENT_" anywhere you want Parent's Name to appear and "_CHILD_" where you want Child's Name to appear in the message. </span>
          </div>
          <div class="form-group">
            <label>Edit Departure Message</label>
            <textarea name="departure" class="form-control"><?php echo (!empty($sms->arrival))? trim($sms->departure): " ";?></textarea>
             <span class="form-text text-muted">Place "_PARENT_" anywhere you want Parent's Name to appear and "_CHILD_" where you want Child's Name to appear in the message. </span>
          </div>

          <div class="row">
            <div class="form-group col">
          <label>Enable SMS Features:</label>
          <select name="sms_feature" id="sms_feature" class="form-control" required>
          
                <option selected value="<?php echo $admin->sms_status; ?>"><?php echo ($admin->sms_status == 1) ? "On": "Off"; ?></option> 
           
            <option value="1">On</option>
            <option value="0">Off</option>
          </select>
        </div>
            <div class="form-group col">
              <label>API Username:</label>
              <input type="text" name="api_username" class="form-control" value="<?php echo (!empty($sms->api_username))? trim($sms->api_username): " ";?>">
            </div>
            <div class="form-group col">
              <label>API Password:</label>
              <input type="password" name="api_password" class="form-control" value="<?php echo (!empty($sms->api_password))? trim($sms->api_password): " ";?>">
            </div>
          </div>

          <button class="btn btn-md btn-warning" name="update" type="submit">Update</button>
        </form>
      </div>
      <div class="col-md-6 col-lg-6">
        <h4>SMS: Day Students</h4>
        <div class="form-group col">
          <label>Arrival Sms:</label>
          <select name="d_arrival" id="d_arrival" class="form-control" required>
          
                <option selected value="<?php echo $admin->day_arrival_sms; ?>"><?php echo ($admin->day_arrival_sms == 1) ? "On": "Off"; ?></option> 
           
            <option value="1">On</option>
            <option value="0">Off</option>
          </select>
        </div>
        <div class="form-group col">
          <label>Departure Sms:</label>
          <select name="d_departure" id="d_departure" class="form-control" required>
          
                <option selected value="<?php echo $admin->day_departure_sms; ?>"><?php echo ($admin->day_departure_sms == 1) ? "On": "Off"; ?></option> 
           
            <option value="1">On</option>
            <option value="0">Off</option>
          </select>
        </div>

         <h4>SMS: Boarding Students</h4>
        <div class="form-group col">
          <label>Arrival Sms:</label>
          <select name="b_arrival" id="b_arrival" class="form-control" required>
          
                <option selected value="<?php echo $admin->board_arrival_sms; ?>"><?php echo ($admin->board_arrival_sms == 1) ? "On": "Off"; ?></option> 
           
            <option value="1">On</option>
            <option value="0">Off</option>
          </select>
        </div>
        <div class="form-group col">
          <label>Departure Sms:</label>
          <select name="b_departure" id="b_departure" class="form-control" required>
          
                <option selected value="<?php echo $admin->board_dept_sms; ?>"><?php echo ($admin->board_dept_sms == 1) ? "On": "Off"; ?></option> 
           
            <option value="1">On</option>
            <option value="0">Off</option>
          </select>
        </div>
      </div>
  </div>
</div>


<?php include 'template/footer.php'; ?>
