<!DOCTYPE html>
<html>
<head>
	<?php
	if($_POST)
	{
		$message = $_POST['message'];

		foreach ($_POST['data'] as $value) {

			$value1 = json_decode($value,true);
			$message1 = stripslashes($message);
			$name = explode(" ",$value1[1]);
			$name = $name[0];
			$message1 = str_replace(array("%THALINO%","%NAME%","%AMOUNT%"),array($value1[0],$name,$value1[2]),$message1);
			$message1 = urlencode($message1);
			$result = file_get_contents("http://sms.myn2p.com/sendhttp.php?user=mustafamnr&password=mnr80211&mobiles=$value1[3]&message=$message1&sender=FAIZST&route=Template");
			// echo $result."<br>";
			// echo "http://sms.myn2p.com/sendhttp.php?user=mustafamnr&password=mnr80211&mobiles=$value1[3]&message=$message1&sender=FAIZST&route=Template"."<br>";

		}
		echo "Message sent successfully";
	}
	?>
	<meta charset="utf-8">
	<title>Faiz Students SMS Service</title>

	<!-- jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

	<!-- Demo stuff -->
	<link class="ui-theme" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/cupertino/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link rel="stylesheet" href="../docs/css/jq.css">
	<link href="../docs/css/prettify.css" rel="stylesheet">
	<script src="../docs/js/prettify.js"></script>
	<script src="../docs/js/docs.js"></script>

	<link rel="stylesheet" href="select2.css">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.0/select2.min.js"></script>
	<style>
	.tablesorter-filter-row td button {
		background-color: red;
		color: white;
		border: #555 1px solid;
	}
	#external_controls input {
		width: 150px;
		margin-left: 5px;
	}
	.selector {
		width: 200px;
	}
	</style>

	<!-- Tablesorter: required -->
	<link rel="stylesheet" href="../css/theme.jui.css">
	<script src="../js/jquery.tablesorter.js"></script>
	<script src="../js/jquery.tablesorter.widgets.js"></script>
	<script src="../js/jquery.jqEasyCharCounter.min.js" type="text/javascript"></script>

<script id="js">$(function(){

	$('.countable2').jqEasyCounter({
		'maxChars': 1000,
		'maxCharsWarning': 145
	});

	$('th input:checkbox').click(function(e) {
        var table = $(e.target).parents('table');
        $('td input:checkbox', table).attr('checked', e.target.checked);
    });


	var $t = $('table').on('filterInit', function () {
			var filters,
			select2Column = 0,
			select2TagColumn = 1,
			$t = $(this),
			$filterCells = $t.find('.tablesorter-filter-row').children(),
			$ext = $('#external_controls'),
			$extCells = $ext.find('td'),
			startSearch = function(){
				filters = [];
				$extCells.each(function(i){
					var v,
					$this = $(this),
					$item = $this.find('select, input');
					// specific method for select2
					if (i === select2Column) {
						v = '/(' + ($this.find('.selector').select2('val') || []).join('$|') + '$)/';
					} else if(i === select2TagColumn){
						v = '/(' + ($this.find('.selectorTag').select2('val') || []).join('|') + ')/';
					}
					if (i !== select2Column) {
						// search for numbers > value
						// v = '>=' + $item.val();
					}
					filters[i] = v || $item.val() || '';
				});
				// start search
				$.tablesorter.setFilters($t, filters, true);
			};

			// hide filter row completely
			$t.find('.tablesorter-filter-row').hide();

			// clone original select and turn it into a select2
			// doing it this way because we can let the filter widget do most of the work
			$filterCells.eq(select2Column)
				.find('select')
				.attr('multiple', 'multiple')
				.addClass('selector')
				.appendTo( $ext.find('.select2') );
			// replace select with an input
			$filterCells.eq(select2Column).html('<input type="search" class="tablesorter-filter">');
			
			// removed first option (it's just a placeholder)
			$ext.find('.selector').find('option:first').remove();
			// set up select2 input
			$ext.find('.selector').select2({
				placeholder : 'AlphaNumeric'
			});

			
			// /******* Select2 Tag Cloud ********/
			// as with above AlphaNumeric filter get the option values from original select
			var optionValues = [];
			$filterCells.eq(select2TagColumn).find('select option').each(function() {
			   optionValues.push($(this).text());
			});
			
			// removed first option (it's just a placeholder)
			optionValues = optionValues.slice(1);
			
			//Create a new hidden input for select2 tag cloud and append it to its external filter cell
			var $selectInput = $('<input type="hidden" class="selectorTag" style="width:200px"/>')
				.appendTo( $ext.find('.select2tag') );
				
			//Replace the original select filter with a search input
			$filterCells.eq(select2TagColumn).html('<input type="search" class="tablesorter-filter">');
			
			// set up select2 tag cloud input
			$selectInput.select2({
				tags : optionValues,
				tokenSeparators : [","],
				placeholder : 'AlphaNumeric Tag'
			});
			
			// turn off built-in filter-select
			$t.find('.filter-select').removeClass('filter-select') // turn off filter select
			this.config.widgetOptions.filter_functions[select2Column] = null;
			this.config.widgetOptions.filter_functions[select2TagColumn] = null;
			
			// input changes trigger a new search
			$ext.find('select, input').on('change', function () {
				startSearch();
			});

		})
		.tablesorter({
			theme: 'jui',
			headerTemplate: '{content}{icon}',
			widgets: ['zebra', 'uitheme','filter']
		});


	});

function selectall(action){

	$(':checkbox:visible').each(function() {
            this.checked = action;                        
        });
	selectsingle();
}

var a = 0;

function selectsingle(){
	window.a = 0;
	$('.value:checkbox').each(function() {
            if(this.checked) window.a++;                        
        });	

	$('#checkcount').html(window.a);
}

</script>

</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

<textarea name="message" style="height:150px; width:400px" class="countable2" id="message"></textarea>
<select id="holder">
	<option value="%THALINO%">Thali Number</option>
	<option value="%NAME%">Name</option>
	<option value="%AMOUNT%">Amount</option>
</select>
<input type="button" name="add" value="Add" onClick='document.getElementById("message").value += document.getElementById("holder").value;'>
 <input type="submit" name="msg" value="Send Message" onclick="return confirm('Are you sure?')">
 <a id="checkcount">0</a> Message(s) selected

<?php
$spreadsheet_url="https://docs.google.com/spreadsheet/pub?key=0ArdhkPTPxvG2dG1mb2ZRbjVod1h2UDdvUzZKLWlyM3c&single=true&gid=21&output=csv";

if(!ini_set('default_socket_timeout',15)) echo "<!-- unable to change socket timeout -->";

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {

	$i = 0;
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

				if($i != 0){
							if($data[4] != '1')
							{
								$data[4] = 0;
							}
									
								$spreadsheet_data[] = array($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[12],$data[22]);}
				$i++;
		}
	fclose($handle);
}
else
	die("Problem reading csv");

?>

<table class="tablesorter">
	<thead>
		<tr>
			<th><input type="checkbox" onclick="selectall(this.checked)"/></th>
			<th class="filter-select">Thali No.</th>
			<th>Name</th>
			<th>Contact No.</th>
			<th class="filter-select">F/H</th>
			<th class="filter-select">Active</th>
			<th class="filter-select">Transporter</th>
			<th>Total Pending</th>
			<th>Full Address</th>
		</tr>
	</thead>
	<tbody>

		<?php
		foreach ($spreadsheet_data as $value) {
			?>
			<tr><td><input type="checkbox" name="data[]" value='<?php echo json_encode(array($value[0],$value[1],$value[6],$value[2]));?>' onclick="selectsingle()" class="value"></td><td><?php echo $value[0];?></td><td><?php echo $value[1];?></td><td><?php echo $value[2];?></td><td><?php echo $value[3];?></td><td><?php echo $value[4];?></td><td><?php echo $value[5];?></td><td><?php echo $value[6];?></td><td><?php echo $value[7];?></td></tr>
			<?php
		}
		?>
		

	</tbody>
</table>




</div>

</body>
</form>
</html>
