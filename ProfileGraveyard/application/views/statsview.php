<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//head title passed from conroller
	$this->load->view('header');
	
	if (!empty($data)) {
?>
<script type="text/javascript">
   google.load('visualization', '1', {'packages': ['geochart']});
   google.setOnLoadCallback(drawVisualization);
function drawVisualization() {
  var data = new google.visualization.DataTable();
  data.addRows(60);
  data.addColumn('string', 'State');
  data.addColumn('number', 'Hours Saved');
<?php
		$lastLoc = '';
		$i = 0;
		foreach ($data as $p)
		{
			echo 'data.setValue(' . $i . ', 0, "' . ucwords($p->region) . '");';
			echo 'data.setValue(' . $i . ', 1, ' . $p->hourswasted . ');';
			$i++;
		}
		
?>

  var geochart = new google.visualization.GeoChart(
      document.getElementById('visualization'));
  geochart.draw(data, {region: 'US', resolution: 'provinces', dataMode: 'regions', width: 675, height: 422});
}
<?php
		echo '</script>';
		echo '<div id="visualization"></div>';
	}
	
	$this->load->view('footer');
?>