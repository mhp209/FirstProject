<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 error</title>
 
  <link rel="stylesheet" href="{{ asset('404/404.css') }}">
  <link rel="stylesheet" href="css/responsive.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/slick-theme.css">
  <link rel="stylesheet" href="css/slick.css">
  <!-- <link rel="stylesheet" href="css/aos.css"> -->
</head>
<body>
 
 
<div class="bg-purple">
       
    <div class="stars">
        <div class="central-body">
            <img class="image-404" src="{{ asset('404/404.svg') }}" width="300px">
            <a href="{{ url('/') }}" class="btn-go-home" target="_blank">GO BACK HOME</a>
        </div>
        <div class="objects">
            <img class="object_rocket" src="{{ asset('404/rocket.svg') }}" width="40px">
            <div class="earth-moon">
                <img class="object_earth" src="{{ asset('404/earth.svg') }}" width="100px">
                <img class="object_moon" src="{{ asset('404/moon.svg') }}" width="80px">
            </div>
            <div class="box_astronaut">
                <img class="object_astronaut" src="{{ asset('404/astronaut.svg') }}" width="140px">
            </div>
        </div>
        <div class="glowing_stars">
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
            <div class="star"></div>
 
        </div>
 
    </div>
 
</div>
 
</body>
</html>