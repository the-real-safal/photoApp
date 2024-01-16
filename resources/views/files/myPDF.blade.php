<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>
    <h1>All Captured Images - {{ $title }}</h1>
    <strong>Public Folder:</strong>
    <img src="{{ public_path('dummy.jpg') }}" style="width: 200px; height: 200px">
  
    <br/>
    <strong>Storage Folder:</strong>
    <img src="{{ storage_path('app/public/dummy.jpg') }}" style="width: 200px; height: 200px">
</body>
</html>