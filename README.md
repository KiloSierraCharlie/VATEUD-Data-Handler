# VATEUD Data Handler
Easy to use, object-orientated data handler for the VATEUD API.

## Requirements
* file_get_contents

## Available content lists
* getStaffMembers( vacc* ) - _Get staff members._
* getATCFrequencies( vacc* ) - _Get all approved ATC frequencies._
* getEvents( vacc* ) - _Get all events._
* getMembers( vacc* ) - _Get all members._
* getvACCs() - _Get all vACCs._
* getAirports( countryCode* ) - _Get all airports._
* getNOTAMs( icao ) - _Get all NOTAMs by FIR or Airport ICAO._
* searchFor( functionName, RegEX, variableName ) - _Use RegEX to search variables._

\* designates optional paramater.
## How to use
Bear in mind, this only lists callsigns. You might find it more beneficial to var_dump one of the clients, to see the different variables available to you.
```php
<?php
require( "DataHandler.php" );
$DH = new DataHandler();
foreach( $DH->getvACCS() as $vACC ){
    print( $vACC->name . "<br/>" );
}
```
