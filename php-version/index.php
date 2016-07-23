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

	function validate_data( $data ) {
		$data = trim( $data );
		$data = htmlspecialchars( $data );
		return $data;
	}

  function isValid_date( $date ) {
    if ( ! preg_match( "/^(0?[0-9]|1[0-2])\/[0-9]{2}\/[0-9]{4}$/", $date ) ) {
      return false;
    } else {
      $date_array = explode( "/", $date );
      return ( within_bounds( $date_array[0], 0, 12 ) && //check month
                within_bounds( $date_array[1], 0, 31 ) && //check day
                within_bounds( $date_array[2], 2016, null ) ) ? true : false; //check year and return
    }
  }

  function within_bounds( $number, $min, $max ) {
    if ( ! is_null( $max ) ) { return ( $number >= $min && $number <= $max ) ? true : false; }
    else { return ( $number >= $min ) ? true : false; }
  }

	$event;
	$event_name = "";
	$event_date = "";
	$name_error = "";
	$date_error = "";
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
		if ( empty( $_POST["event_name"] ) ) { $name_error = "Name is required"; }
		else {
			$event_name = validate_data( $_POST["event_name"] );
      $event_name = stripslashes( $event_name );
			if ( ! preg_match( "/^[a-zA-Z]+[ ]*[a-zA-z0-9]*$/", $event_name ) ) {
        $name_error = "The event name should start with a letter and only containt letters, numbers and spaces";
        $event_name = "";
      }
		}

		if ( empty( $_POST["event_date"] ) ) { $date_error = "Date is required"; }
		else {
			$event_date = validate_data( $_POST["event_date"] );
			if ( ! isValid_date( $event_date ) ) {
        $date_error = "The event date must be a valid date (MM/DD/YYYY)";
        $event_date = "";
      } else if ( date_create( $event_date ) <= date_create( "now" ) ) {
        $date_error = "The event date should be in the future";
        $event_date = "";
      }
		}

		if ( ! ( $event_name == "" || $event_date == "" ) ) {
      $event = array( "event_name" => $event_name, "event_date" => $event_date );
      Bakery::bakeCookies( $event );
    }
	}
 ?>

<html>
<head>
	<title>Countdown App</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
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
		<h3>Eventboard</h3>
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
	</div>
	<div id="event-form">
		<button type="button" onclick="">New Event</button>
		<form method="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] );  ?>">
			<input type="text" placeholder="ie Graduation" name="event_name" required/>
			<input type="date" name="event_date" required
        placeholder="<?php $today = getdate(); echo "ie " . $today["mon"] . "/" . $today["mday"] . "/" . $today["year"]; ?>"/>
			<br /><p class="error"><?php echo $name_error; ?></p>
			<p class="error"><?php echo $date_error; ?></p>
			<input id="button" type="submit" value="Add Event">
		</form>
	</div>

	<div id="featured-countdown">
		<h3>Featured Countdowns</h3>
		<script>
			//javascript animation in here...
		</script>
	</div>

</body>
</html>
