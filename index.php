<!-- <?php
	class Countdowns {
		public $username;
		public $events;
		public function __construct( $username = "EventGoer", $events = null ) {
			$this->username = $username;
			$this->events = $events;
		}

		public function add_event( $name, $date ) {
			if( is_null( $this->events ) ) {
				$this->events = array( $name=>$date );
			} else {
				$this->events[$name] = $date;
			}
		}
	}

	class Bakery {
		public static function bakeCookies( $ingredients ) {
			if ( !is_null( $ingredients ) ) {
				if ( !isset( $ingredients["username"] ) ) { $ingredients["username"] = "EventGoer"; }
				setcookie( "user", $ingredients["username"] );
				setcookie( "" . $ingredients["event_name"] . $ingredients["event_date"],
					"" .$ingredients["event_name"] . "," . $ingredients["event_date"]);
			}
		}

		public static function cookiesAreDone() {
			$cookie_count = count( $_COOKIE );
			$cookie_values;
			if ( $cookie_count > 0 ) {
				foreach ( $_COOKIE as $name->$value ) {
					if ( $name == "user" ) {
						$cookie_values = $value;
					} else {
						$event = explode( ",", $value );
						$cookie_values = $event[0];
						$cookie_values = $event[1];
					}
				}
			}
			return ( count( $cookie_values ) == 0 ) ? null : $cookie_values;
		}
	}

	public function validate_input( $data ) {
		$data = trim( $data );
		$data = stripslashes( $data );
		$data = htmlspecialchars( $data );
		return $data;
	}

	$event;
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
			else { $ur_countdowns->save_event( $event_name, $event_date ); }
		}

		if ( $event_name == "" || $event_date = "" ) { $event = null; }
		else { $event = array( "event_name" => $event_name, "event_date" => $event_date ); }

		//Save cookies
		Bakery::bakeCookies( $event );
	}
 ?> -->

<!DOCTYPE html>
<html>
<head>
	<title>Countdown App</title>
</head>

<body>
	<!-- <?php
		//Grab cookies
		$cookies = Bakery::cookiesAreDone();
		$ur_countdowns;
		if ( is_null( $cookies ) ) {
			$ur_countdowns = new Countdowns();
		} else {
			$ur_countdowns = new Countdowns( $cookies[0] );
			$temp_key;
			for ( $i = 1; $i < count( $cookies ); $i++ ) {
				if ( $i % 2 == 0 ) {
					$ur_countdowns->add_event( $temp_key, $cookies[ $i ] );
				} else {
					$temp_key = $cookies[ $i ];
				}
			}
		}
	?> -->
	<div id="title-banner">
		<h1 id="title"><?php echo "" . ur_countdowns->username . "'s Countown"?></h1>
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

	<div id="featured-countdown">
		<script>
			//javascript animation in here...
		</script>
	</div>

</body>
</html>
