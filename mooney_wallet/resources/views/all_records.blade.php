<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body class="body">
<input type="text" value="dssds">
<input type="text" value="dssds">

</body>
<script>
    var  node = document.createElement("DIV");
    var textnode = document.createTextNode("Water");
    node.appendChild(textnode);
    document.querySelector('body').appendChild(node);
</script>
</html>
