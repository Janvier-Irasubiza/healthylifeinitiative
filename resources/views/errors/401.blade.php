<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>401 Unauthorized access</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ asset('errors.css') }}" />

</head>

<body>

	<div id="notfound">
		<div class="notfound border">

            <a href="{{ route('index') }}" class="logo" style="background: none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>

			<div class="notfound-404">
				<h1>Oops!</h1>
				<h2>401 - Resource not accessible.</h2>
			</div>
            
          @if(Auth::user())
			<a href="{{ route('client.dashboard') }}" class="rounded">Go TO Dashboard</a>
          @elseif(Auth::guard('admin') -> user())
          	<a href="{{ route('admin.dashboard') }}" class="rounded">Go TO Dashboard</a>
          @else
          	<a href="{{ route('index') }}" class="rounded">Go TO Homepage</a>
          @endif
		</div>
	</div>

</body>

</html>
