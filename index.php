<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fetch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        table { border-collapse: collapse; width: 85%; color: #010101; font-family: 'Roboto'; font-size: 20px; text-align: center; margin: 30px auto; }
        th {  padding: 10px; background-color: #69779b;}
        th > a { color: #f0ece2; text-decoration: none; }
        th > a:hover { color: #010101; }
        tr:nth-child(even) { background-color: #f0ece2; }
    </style>
</head>
<body>
    <?php
        $server = "localhost";
        $user = "root";
        $password = "";
        $dbName = "targetDb";

        $conn = new mysqli( $server, $user, $password, $dbName );

        if ($conn->connect_error ) {
            die( "Connection Failed: " . $conn->connect_errno );
        }

        $sql = "SELECT ClientID, ClientName, ClientAddress FROM Clients";

        $sort = " ORDER BY ClientName DESC";

        $concat = $sql . " " . $sort . " ";

        $result = $conn->query( $concat );

        echo "<table><thead>";
            display_query_header( $result );
        echo "</thead><tbody>";
            display_query_rows( $result );
        echo "</tbody></table>";

        $conn->close();

        /********************************************************/ 
        function display_query_header( $result ) {
            $field_cnt = $result->field_count;
            for ( $i = 0; $i < $field_cnt; $i++ ) { 
                $field = $result->fetch_field();
                echo "<th><a href = '$i'>" . $field->name . "</a></th>";

                $url = $_GET[ " " . $i . " sort-order" ] ;
            }
        }
        /********************************************************/ 
        function display_query_rows( $result ) {
            $field_cnt = $result->field_count;
            if ( $result->num_rows > 0 ) {
                while ( $row = $result->fetch_array() ) {
                    echo "<tr>";
                    for ( $j = 0; $j < $field_cnt; $j++ ) { 
                        echo "<td>" . $row[ $j ] . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "0 results.!";
            }
        }
    ?>    
</body>
</html>