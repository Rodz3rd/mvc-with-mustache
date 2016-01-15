<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<input type="file" id="file" />

<script type="text/javascript" src="public/assets/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
$(function () {
	$("#file").change( function () {
		var file = $(this).val().split('\\');


		console.log( file[file.length - 1] );
	})
});
</script>

</body>
</html>