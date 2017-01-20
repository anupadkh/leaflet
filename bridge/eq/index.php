<?php require_once 'includes/initialize.php';
  // print_r($_POST);
      if (isset($_POST['submit'])) {
        $object =  Vdc::find_by_id($_POST['vdc']);
      } else{
        $object = Vdc::find_by_id(1);
      }

      

 ?><!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--Load the AJAX API-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawChart1);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['पूर्ण क्षति', <?php echo $object->full_damage; ?>],
          ['आंशिक क्षति', <?php echo $object->partial_damage; ?>],
          ['सामान्य क्षति', <?php echo $object->normal_damage ?>]
        ]);

        // Set chart options
        var options = {'title':'<?php echo $object->name; ?> गा.वि.सको भुकम्पबाट घरधुरीमा भएको क्षति नोक्सानीको विवरण',
                       'width':800,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    function drawChart1() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['पूर्ण क्षति', <?php echo Vdc::sum_of_column('full_damage'); ?>],
          ['आंशिक क्षति', <?php echo Vdc::sum_of_column('partial_damage'); ?>],
          ['सामान्य क्षति', <?php echo Vdc::sum_of_column('normal_damage'); ?>]
        ]);

        // Set chart options
        var options = {'title':'पर्वत जिल्लाको भुकम्पबाट घरधुरीमा भएको क्षति नोक्सानीको विवरण',
                       'width':800,
                       'height':600};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
      
    </script>
  </head>

  <body>
  <form name="eq_details" action="#" method="post">

    <select name="vdc">
      <?php 
        $all = Vdc::find_all();
        foreach ($all as $one) {
          echo "<option value=".$one->id;
          if ($one->id == $object->id) {
            echo " selected";
          }
          echo ">".$one->name."</option>";
        }
       ?>
    </select>
    <input type="submit" name="submit" value="Submit">
  </form>
    
    <!--Div that will hold the pie chart-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <div class="row">
      <div class="col-lg-6" id="chart_div"></div>
      <div class="col-lg-6" id="chart_div2"></div>
    </div>
  </body>
</html>