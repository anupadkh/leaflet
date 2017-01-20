
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              जिल्ला विकास समितिको कार्यालय पर्वत &copy; 2016
              <a href="index.php#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
	<script type="text/javascript">
        $(document).ready(function () {
            <?php if ($gritter !== false) {
                ?>
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: '<a href=\'<?php echo $header."&position=".$_GET['position'] ?>\'> नयाँ थप्नुहोस्!</a>',
            // (string | mandatory) the text inside the notification
            text: '<a href=\'<?php echo $header."&position=".$_GET['position'] ?>\'> यहाँ क्लिक गर्नुहोस् ।</a>',
            // (string | optional) the image to display on the left
            image: 'assets/img/logo.png',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false;
        <?php //if code
            } 
        ?>
        });
	</script>
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
<?php 
if ($_GET['status'] =='saved') {
  echo "alert('Your data has been successfully updated');";
}
if ($_GET['deleted'] == 'true') {
  echo "alert('Your details has been successfully erased');";
}

 ?>
 /*$('document').ready(function(){
    var form = document.getElementById('file-form');
    var fileSelect = document.getElementById('file-select');
    var uploadButton = document.getElementById('upload-button');
    form.onsubmit = function(event) {
      event.preventDefault();

      // Update button text.
      uploadButton.innerHTML = 'Uploading...';

      // The rest of the code will go here...
    }
 });*/

    </script>
  
    <script type="text/javascript" src="assets/nepali.datepicker.v2.1.min.js"></script>
    <script type="text/javascript">$(document).ready(function(){
            <?php echo $scripts ;?>
            });</script>
  </body>
</html>
