<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="{{url('admin/test')}}" method="post">
    {{csrf_field()}}
<tr><td>商品图片</td>
  <td><input type="file" name="goods_pic" /></td></tr>
    <input type="submit" value="提交">
</form>
</body>
</html>