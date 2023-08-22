<!DOCTYPE html>

<html>

<head>

    <title>{{ $mailData['title'] }}</title>

    <style>
body {
  margin: 0;
  padding: 0;
  background-color: gray;
}

h1 {
    font-size: 1.8em;
    font-weight:normal;
}

div {
    background-color: white
}
    </style>


</head>

<body>

    <h3>{{ $mailData['title'] }}</h3>

    <p>{{ $mailData['greeting'] }}</p>
    <p>{{ $mailData['body'] }}</p>
    <p>{{ $mailData['signature'] }}</p>


    <p>Thank you</p>

</body>

</html>
