<!DOCTYPE html>
<html>
<head>
	<title>Countdown App</title>
</head>

<body>
	<?php
		public class Countdowns {
			public $username;
			public $events;
			public function __constructor( $username = "EventGoer", $events = null ) {
				$this->username = $username;
				$this->events = $events;
			}

			public function save() {}

			public function save_event( $name, $date ) {
				$this->events[$name] = $date;
				$this->save();
			}
		}
		
		//TODO: grab cookies info and pass to constructor
		$ur_countdowns = new Countdowns();
	?>
	<div id="title-banner">
		<h1 id="title">User's Countown</h1>
	</div>

	<div id="dashboard">
		<table>
			<thead>
				<tr><th>Countdowns</th></tr>
				<tr>
					<th>Event</th>
					<th>Date of</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>...</td>
					<td>...</td>
				</tr>
			</tbody>
		</table>

		<button type="button" onclick="">New Event</button> 
		<form method="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] );  ?>">
			<input type="text" placeholder="Event name" name="even_name" required/>
			<input type="date" name="event_date" required/>
			<br /><p class="error">><?php echo $error_name; ?><</p>
			<p class="error">><?php echo $error_date; ?><</p>
			<input type="submit">
		</form>
	</div>

	<?php
		$event_name = "";
		$event_date = "";
		$name_error = "";
		$date_error = "";
		if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
			if ( empty( $_POST["event_name"] ) ) { $name_error = "Name is required"; }
			else { 
				$eventName = validate_input( $_POST["event_name"] );
				if ( pattern( $eventName ) ) { $name_error = "Name should only contain letters and spaces"; }
			}

			if ( empty( $_POST["eventDate"] ) ) { $date_error = "Date is required"; }
			else { 
				$event_date = validate_input( $_POST["event_date"] ); 
				if ( $event_date ) { $date_error = "The vent date hould be in the future"; }//date_diff( $event_date,get_date() )
				else { $ur_countdowns->save_event( $event_name, $event_date );
			}
		}

		public function validate_input( $data ) {
			$data = trim( $data );
			$data = stripslashes( $data );
			$data = htmlspecialchars( $data );
			return $data;
		}
	?>

	<div id="featured-countdown">
		<script>
			//javascript animation in here...
		</script>
	</div>

</body>
</html>
