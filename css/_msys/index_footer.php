    <div class="bs-example">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static">
                <div class="modal-content">
        
                </div>
            </div>
        </div>
    
        <div id="myModal-xl" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg static" style="width: 96%;">
                <div class="modal-content">
        
                </div>
            </div>
        </div>
    </div>
	</form>
`	<!--
	<div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
              <b>Version</b> 1.0
            </div>
            © Hak Cipta Terpelihara Jabatan Kemajuan Islam Malaysia 2019<br>
            Paparan Terbaik dengan menggunakan Mozilla Firefox, Google Chrome & Internet Explorer versi terkini dengan resolusi melebihi 1024 x 768
        </footer>
	</div>
    -->
		<!--<script src="assets/vendor/modernizr/modernizr.js"></script>-->

		<!-- Vendor -->
		<script src="../assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="../assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="../assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="../assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="../assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="../assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="../assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<!-- <script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script> -->
		<!-- <script src="assets/vendor/flot/jquery.flot.js"></script> -->
		<!-- <script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script> -->
		<!-- <script src="assets/vendor/flot/jquery.flot.pie.js"></script> -->
		<!-- <script src="assets/vendor/flot/jquery.flot.categories.js"></script> -->
		<!-- <script src="assets/vendor/flot/jquery.flot.resize.js"></script> -->
		<!-- <script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script> -->
		<!-- <script src="assets/vendor/raphael/raphael.js"></script> -->
		<!-- <script src="assets/vendor/morris/morris.js"></script> -->
		<!-- <script src="assets/vendor/gauge/gauge.js"></script> -->

		<!--
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>

		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		-->
		<!-- Theme Base, Components and Settings -->
		<script src="../assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="../assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<!--<script src="../assets/javascripts/dashboard/examples.dashboard.js"></script>-->
        
        
        <?php if(!empty($JFORM) && $JFORM=='LIST'){ ?>

			<script src="../vendors/datatables.net/js/jquery.dataTables.js"></script>
			<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.js"></script>
			<script src="../vendors/datatables.net-buttons/js/dataTables.buttons.js"></script>
			<!--
			<script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
			<script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
			<script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>-->
			<script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
			<script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
			<script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
			<script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
			<script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
			<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
			<!--<script src="vendors/jszip/dist/jszip.min.js"></script>-->
			<!--<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
			<script src="vendors/pdfmake/build/vfs_fonts.js"></script>-->
			
			<script>
			  $(function () {
				//$("#datatable-responsive").DataTable();
				$('#datatable-responsive').DataTable({
				  "paging": false,
				  "lengthChange": true,
				  "searching": false,
				  "ordering": false,
				  "info": false,
				  "autoWidth": true
				});
			  });
			</script>
        
        <?php } ?>
        
<?php 
//$conn->debug=true;
$rs = $conn->query("SELECT * FROM information_schema.`processlist` WHERE TIME>=300");
while(!$rs->EOF){
	$process_id=$rs->fields['ID'];
	print "<br>".$rs->fields['ID'].":".$rs->fields['TIME'];
	$conn->execute("KILL $process_id");
	$rs->movenext();
}

$conn->close(); 
?>          
	</body>
</html>
<script>
/*$('#myModal').on('hidden.bs.modal', function () {
 location.reload();
})*/
//Edit SL: more universal
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

</script>
