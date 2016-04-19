<html>

<head> </head>

<body>
	    @foreach($errors->all() as $error)
	    	<li> {{ $error }} </li>
	    @endforeach

	    <?php

			echo Form::open(array('url' => 'login/submit', 'method' => 'post'));

	    	echo Form::label('email', 'Email ', ['class' => 'control-label']);
			echo Form::text('email');

			echo Form::label('password', 'Password ', ['class' => 'control-label']);
			echo Form::text('password');

			echo Form::submit('Register');

			echo Form::close();
		?>


</body>

</html>