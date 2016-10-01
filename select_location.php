<div class="ch-container">
    <div class="row" style="padding-top:40px;">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Select Your Location
            </div>
           
				 <?php if($this->session->flashdata('success_message')){ ?>
				<span class="alert alert-danger col-lg-12">
					<button class="close" data-dismiss="alert" type="button">×</button>
                    <?php echo $this->session->flashdata('success_message'); ?>
                </span>
			<?php } ?>
			<?php  echo form_open('login/selectLocation');?>
                <fieldset>
				<?php 
				$user_id = $this->session->userdata('user_id');
				$officeId = $this->session->userdata('office_id');
				//print_r($user_id);die;
				//date_format(str_to_date(om.access_rights_to, "%d/%m/%Y"), "%Y-%m-%d")
				$this->db->select('upm.role_permission_id,om.office_id,om.office_name,om.office_operation_type,rsm.regional_store_type,date_format(str_to_date(om.access_rights_from, "%d/%m/%Y"), "%Y-%m-%d") as access_rights_from,date_format(str_to_date(om.access_rights_to, "%d/%m/%Y"), "%Y-%m-%d") as access_rights_to')->from('user_role_permission_master as upm');
				$this->db->join('office_master as om','upm.office_id=om.office_id');
				$this->db->join('regional_store_master as rsm','rsm.regional_store_id=om.regional_store_id');
				$this->db->where(array('upm.user_id'=>$user_id));
				$locationLists = $this->db->get()->result();
				
				//echo $this->db->last_query();
				if($officeId == 'H'){
					//$rolePermission = $this->db->get_where('user_role_permission_master as upm',array('user_id'=>$user_id,'office_id'=>"H"))->row();
					$transfer_to=array();
					$transfer_to[0] ->office_id= "H";
					$transfer_to[0] ->office_name="MMTC";
					$transfer_to[0] ->regional_store_type="HEAD OFFICE";
				
					$locationLists = array_merge($transfer_to,$locationLists);
				}
				
				
			//	print_r($locationLists);
				
				?>
					<div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <div class="controls">
						<?php 
						//print_r($locationLists);?>
							<select id="office_id" class="form-control" name="office_id" style="height: 54px;">
							<?php $i=1; foreach($locationLists as $location) { 
							
							if( strtotime($location->access_rights_from) <= strtotime(date('Y-m-d',strtotime('now'))) && ($location->access_rights_to == '' || $location->access_rights_to == '0000-00-00' || strtotime($location->access_rights_to) >= strtotime(date('Y-m-d',strtotime('now')))))
							{
							$office_id=$location->office_id;
							$role_permission_id=$location->role_permission_id;
							$user_role_data=$this->db->get_where('user_role_permission_master',array('user_id'=>$user_id,'role_permission_id'=>$role_permission_id,'office_id'=>$office_id))->row();
							// echo "<pre>";
							// print_r($locationLists); die;
							$location_office_name=$location->office_name;
							$regional_store_type=$location->regional_store_type;
							if($user_role_data->regional_store_id!='0')
							{
								
								$regionalStoreData_res = $this->db->select('*')->from('regional_store_master')->where(array('regional_store_id'=>$user_role_data->regional_store_id))->get()->row();
								$location_office_name=$regionalStoreData_res->regional_store_name;
								$regional_store_type=$regionalStoreData_res->regional_store_type;
							}
							?>
								<option <?php if($i=='1') { echo "selected"; } ?> value="<?php echo $location->office_id; ?>"><?php echo $location_office_name;?>-<?php echo $location->office_operation_type;?>(<?php echo $regional_store_type;?>)</option>
							<?php $i++; 
							}
							}
							?>
							</select>
						</div>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-4">
                         <button type="submit" class="btn btn-primary">Submit</button>
                    </p>
                </fieldset>
			<?php 
			echo form_close();
			?>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="<?php echo base_url();?>files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="<?php echo base_url();?>files/js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='<?php echo base_url();?>files/bower_components/moment/min/moment.min.js'></script>
<script src='<?php echo base_url();?>files/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo base_url();?>files/js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="<?php echo base_url();?>files/bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo base_url();?>files/bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="<?php echo base_url();?>files/js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="<?php echo base_url();?>files/bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="<?php echo base_url();?>files/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="<?php echo base_url();?>files/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo base_url();?>files/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo base_url();?>files/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="<?php echo base_url();?>files/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo base_url();?>files/js/jquery.history.js"></script>
<!-- application script for mmtc demo -->
<script src="<?php echo base_url();?>files/js/mmtc.js"></script>

</body>
</html>
	<script language="JavaScript">
  
//////////F12 disable code////////////////////////
    document.onkeypress = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
           //alert('No F-12');
            return false;
        }
    }
    document.onmousedown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            //alert('No F-keys');
            return false;
        }
    }
	document.onkeydown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            //alert('No F-keys');
            return false;
        }
    }
/////////////////////end///////////////////////


//Disable right click script
//visit http://www.rainbow.arch.scriptmania.com/scripts/
var message="Sorry, right-click has been disabled";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
//
function disableCtrlKeyCombination(e)
{
//list all CTRL + key combinations you want to disable
var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j' , 'w');
var key;
var isCtrl;
if(window.event)
{
key = window.event.keyCode;     //IE
if(window.event.ctrlKey)
isCtrl = true;
else
isCtrl = false;
}
else
{
key = e.which;     //firefox
if(e.ctrlKey)
isCtrl = true;
else
isCtrl = false;
}
//if ctrl is pressed check if other key is in forbidenKeys array
if(isCtrl)
{
for(i=0; i<forbiddenKeys.length; i++)
{
//case-insensitive comparation
if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
{
//alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
return false;
}
}
}
return true;
}
</script>