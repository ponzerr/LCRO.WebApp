<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Marriage License Application</title>
</head>
<body>
    <h1>Marriage License Application</h1>

    <p>Registry No: {{ $mcert->mcert_registry_no }}</p>
    <p>Groom Name: {{ $mcert->mcert_g_first_name }} {{ $mcert->mcert_g_last_name }}</p>
    <p>Bride Name: {{ $mcert->mcert_b_first_name }} {{ $mcert->mcert_b_last_name }}</p>

    <p>Custom Data: {{ $customData }}</p>
</body>
</html>
