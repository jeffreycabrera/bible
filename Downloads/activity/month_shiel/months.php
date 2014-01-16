<html>
<head>
	<title>Exercise</title>
</head>
<body>

Years :

<select name='years' id='years'>
<?php
for($i=1950 ; $i <= 2016 ; $i++):
?>

<option value='<?= $i ?>'><?= $i ?></option>
<?php endfor ?>

</select>
<select id='months' name='month'>
<option value='jan'>January</option>
<option value='feb'>February</option>
<option value='mar'>March</option>
<option value='apr'>April</option>
<option value='may'>May</option>
<option value='jun'>June</option>
<option value='jul'>July</option>
<option value='aug'>August</option>
<option value='sep'>September</option>
<option value='oct'>October</option>
<option value='nov'>November</option>
<option value='dec'>December</option>
</select>
<select id='days'>
	<?php
	for($i=1;$i<=31;$i++):
	?>
	<option value='<?= $i ?>'><?= $i ?></option>
<?php endfor ?>
</select>
<script type="text/javascript" src='jquery.1.10.2.js'></script>
<script type="text/javascript">
$(document).ready(function(){
	var month=$('#months').val();
	var year=$('#years').val();
	$('#months').on('change',function(){
		month=$('#months').val();
		year=$('#years').val();
		$.ajax({
			url:'days.php',
			data:{month:month,year:year},
			dataType:'JSON',
			method:'GET',
			success:function(response){
				var days=response.days;
				var str ='';
				for(i =1;i <= days ;i++){
					str += '<option value = "' + i + '">';
					str += i;
					str += '</option>';
				}
				$('#days').html(str);
			}

		});
	});
});
</script>

</body>
</html>