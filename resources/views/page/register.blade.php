<html>

<head> </head>

<body>
	    @foreach($errors->all() as $error)
	    	<li> {{ $error }} </li>
	    @endforeach

	    <?php

			echo Form::open(array('url' => 'register/submit', 'method' => 'post'));

	    	echo Form::label('name', 'Name ', ['class' => 'control-label']);
			echo Form::text('name');

			echo Form::label('city', 'City ', ['class' => 'control-label']);
			echo Form::text('city');

			echo Form::submit('Register');

			echo Form::close();
		?>


</body>

</html>