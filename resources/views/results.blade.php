<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LCRO</title>
</head>
<body>
    <a href="upload">Back to search</a>
    @foreach ($results as $result)
    <div>
        <h3>{{ $result['objectName'] }}</h3>
        <!-- <a href="{{ asset('pdf/' . str_replace('.json','',$result['objectKey'])) }}" target="_blank">View File</a> -->
    </div>
    @endforeach
</body>
</html>