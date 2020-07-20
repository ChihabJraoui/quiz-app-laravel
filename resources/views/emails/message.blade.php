<html>

	<body style="background: #888;">

		<section style="background: #EEE; color: #444; padding: 20px;">
			<h1> Online Resume : New Message</h1>

			<h3>Sender Name: {{ $name }}</h3>
			<h3>Sender Email: {{ $email }}</h3>

			<h3>Message: </h3>
			<p style="border: solid 1px #CCC; padding: 10px; background: #FFF">
				{{ $body }}
			</p>
		</section>
	</body>

</html>