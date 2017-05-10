<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style/css/ch-ui.admin.css">
	<link rel="stylesheet" href="style/font/css/font-awesome.min.css">
</head>
<body>

<table border="1">
	<tr>
		<td>ID</td>
		<td>图片</td>
	</tr>
	@foreach($file as $val)
		<tr>
			<td>{{$val->file_id}}</td>
			<td><img src="{{$val->file_path}}" width="50" height="50" alt="" style="cursor:pointer"></td>
		</tr>
	@endforeach
</table><span id="transmark" style="display: none; width: 0px; height: 0px;"></span>
</body>
</html>