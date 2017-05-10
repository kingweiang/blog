<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style/css/ch-ui.admin.css">
	<link rel="stylesheet" href="style/font/css/font-awesome.min.css">
</head>
<body>
<form method="POST" action="{{URL('admin/file')}}"enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<input type="file" name="myfile" />
	<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>