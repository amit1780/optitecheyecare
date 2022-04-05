<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>  <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © optitecheyecare | developed by <a href='http://www.softvisionindia.com' target='_blank'>Softvision India</a></span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?php echo site_url('logout'); ?>">Logout</a>
          </div>
        </div>
      </div>
    </div>
    
    <script>
      function getState(country_id)
        {
    		$.ajax({
    			url:'<?php echo site_url('ajaxGetSatetByCountryId'); ?>',
    			method: 'post',
    			data: {country_id: country_id},
    			dataType: 'json',
    			success: function(response){
    				var htm = '<option value="">-- Select State --</option>';					
    				$.each(response, function(i,res) {
    					htm += '<option value="'+ res.state_id +'">'+ res.name +'</option>';
    				});
    				
    				htm += '<option value="addState" style="color: #007bff;">Add State</option>';
    				
    				$("#state_id").html(htm);			
    			}
    		});
    	}
    </script>
    <script>
    	$(document).ready(function(){
    	  $('[data-toggle="tooltip"]').tooltip(); 
    	  
    	   setTimeout(function(){
				$(".alert").hide();			
			}, 10000);
    	  
    	
			$("#quote_id").keypress(function (e) {				
				if (e.which != 8 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
					//display error message
					//$("#errmsg").html("Digits Only").show().fadeOut("slow");
					alert("Type Only Number");
						  return false;
				}
			});
			
			$("#order_id").keypress(function (e) {	
				
				if (e.which != 8 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
					//display error message
					//$("#errmsg").html("Digits Only").show().fadeOut("slow");
					alert("Type Only Number");
						  return false;
				}
			});
			
			$("#challan_id").keypress(function (e) {				
				if (e.which != 8 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
					//display error message
					//$("#errmsg").html("Digits Only").show().fadeOut("slow");
					alert("Type Only Number");
						  return false;
				}
			});
		});
		
    </script>

    <!-- Bootstrap core JavaScript-->
   
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/demo/chart-area-demo.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/financialscript.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-confirm.min.js"></script>
	
	<script>
		$(document).ready(function(){
			var getfqyear = '<?php echo $this->input->get('fqyear'); ?>';	
			if(getfqyear){
				$("#titlequote").html('Q'+getfqyear);
				$("#fqyear").val(getfqyear);
			}		
			var getfoyear = '<?php echo $this->input->get('foyear'); ?>';
			if(getfoyear){
				$("#titleorder").html('O'+getfoyear);		
				$("#foyear").val(getfoyear);
			}
			var getfcyear = '<?php echo $this->input->get('fcyear'); ?>';
			if(getfcyear){
				$("#titlechallan").html('C'+getfcyear);		
				$("#fcyear").val(getfcyear);
			}
			var getfcomyear = '<?php echo $this->input->get('fcomyear'); ?>';
			if(getfcomyear){
				$("#titleComplain").html('SR'+getfcomyear);		
				$("#fcomyear").val(getfcomyear);
			}
		});
	</script>

  </body>

</html>