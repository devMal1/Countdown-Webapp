<!DOCTYPE html>
<?php
	class Countdowns {
		public $username;
		public $events;
		public function __construct( $username = "EventGoer", $events = null ) {
			$this->username = $username;
			$this->events = $events;
		}

		public function add_event( $name, $date ) {
			if( is_null( $this->events ) ) {
				$this->events = array( array( $name, $date ) );
			} else {
				$this->events[] = array( $name, $date );
			}
		}

    public function display_events() {
      if ( ! is_null( $this->events ) ) {
        for ($i = 0; $i < count( $this->events ); $i ++ ) {
          echo "<tr>";
            echo "<td>" . $this->events[$i][0] . "</td>"; //event name
            echo "<td>" . $this->events[$i][1] . "</td>"; //event date
          echo "</tr>";
        }
      } else {
        echo "<tr><td>No events to show...</td></tr>";
      }
    }

	}

	class Bakery {
		public static function bakeCookies( $ingredients ) {
			if ( ! is_null( $ingredients ) ) {
				if ( ! isset( $ingredients["username"] ) ) { $ingredients["username"] = "EventGoer"; }
				setcookie( "user", $ingredients["username"] );
				setcookie( $ingredients["event_name"] . $ingredients["event_date"],
					$ingredients["event_name"] . "," . $ingredients["event_date"]);
			}
		}

		public static function cookiesAreDone() {
			$cookie_count = count( $_COOKIE );
			$cookie_values = null;
			if ( $cookie_count > 0 ) {
				foreach ( $_COOKIE as $name => $value ) {
					if ( $name == "user" ) {
						$cookie_values = array( $value );
					} else {
						$event = explode( ",", $value );
						array_push( $cookie_values, $event[0], $event[1] );
					}
				}
      }
      return $cookie_values;
		}
	}

	function validate_input( $data ) {
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
			$event_name = validate_input( $_POST["event_name"] );
			if ( ! preg_match( "/^[a-zA-Z]+[ ]*$/", $event_name ) ) {
        $name_error = "The event name should start with a letter and only containt letters and spaces";
        $event_name = "";
      }
		}

		if ( empty( $_POST["event_date"] ) ) { $date_error = "Date is required"; }
		else {
			$event_date = htmlspecialchars( $_POST["event_date"] );
			if ( false /*date_diff( $event_date, getdate() ) <= 0*/ ) {
        $date_error = "The event date should be in the future";
        $event_date = "";
      }
		}

		if ( ! ( $event_name == "" || $event_date = "" ) ) {
      //Save cookies
      ////////////////////////////////////////////////////
      echo "DEBUG: " . $event_date;
      $event = array( "event_name" => $event_name, "event_date" => $event_date );
      Bakery::bakeCookies( $event );
    }
	}
 ?>

<html>
<head>
	<title>Countdown App</title>
</head>

<body>
	<?php
		//Grab cookies
		$cookies = Bakery::cookiesAreDone();
		$ur_countdowns;
		if ( is_null( $cookies ) ) {
			$ur_countdowns = new Countdowns();
		} else {
			$ur_countdowns = new Countdowns( $cookies[0] );
			$temp_key;
			for ( $i = 1; $i < count( $cookies ); $i++ ) {
				if ( $i % 2 != 0 ) { $temp_key = $cookies[ $i ]; }
        else { $ur_countdowns->add_event( $temp_key, $cookies[ $i ] ); }
			}
		}
	?>
	<div id="title-banner">
		<h1 id="title"><?php echo $ur_countdowns->username . "'s Countdown"?></h1>
	</div>

	<div id="dashboard">
		<table>
			<thead>
				<tr><th colspan="2">Countdowns</th></tr>
				<tr>
					<th>Event</th>
					<th>Date of</th>
				</tr>
			</thead>
			<tbody>
				<?php $ur_countdowns->display_events(); ?>
			</tbody>
		</table>

		<button type="button" onclick="">New Event</button>
		<form method="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] );  ?>">
			<input type="text" placeholder="ie Graduation" name="event_name" required/>
			<input type="date" name="event_date" required
        placeholder="<?php $today = getdate(); echo "ie " . $today["mon"] . "/" . $today["mday"] . "/" . $today["year"]; ?>"/>
			<br /><p class="error"><?php echo $name_error; ?></p>
			<p class="error"><?php echo $date_error; ?></p>
			<input type="submit" value="Add Event">
		</form>
	</div>

	<div id="featured-countdown">
		<script>
			//javascript animation in here...
		</script>
	</div>

</body>
</html>
