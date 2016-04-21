<html>

<head> </head>

<body>
	    @foreach($errors->all() as $error)
	    	<li> {{ $error }} </li>
	    @endforeach

	    <?php

			echo Form::open(array('url' => 'register/submit', 'method' => 'post'));

	    	echo Form::label('email', 'email ', ['class' => 'control-label']);
			echo Form::text('email');

			echo "<br>";

			echo Form::label('city', 'City ', ['class' => 'control-label']);
			echo Form::text('city');

			echo "<br>";

			echo Form::label('password', 'Password ', ['class' => 'control-label']);
			echo Form::text('password');

			echo "<br>";

			echo Form::submit('Register');

			echo Form::close();
		?>


</body>

</html>