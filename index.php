<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fetch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* 010101 | 69779B | ACDBDF | F0ECE2 */
        
        table { border-collapse: collapse; width: 85%; color: #010101; font-family: 'Roboto'; font-size: 20px; text-align: center; margin: 30px auto; }
        th {  padding: 10px; background-color: #69779b;}
        th > a { color: #F0ECE2; text-decoration: none; }
        th > a:hover { color: #010101; }
        tr:nth-child(even) { background-color: #F0ECE2; }
    </style>
</head>
<body>
    <?php

        $conn = new mysqli( "localhost", "root", "", "targetDb" );

        if ( $conn->connect_error ) {
            die( "Connection Failed: " . $conn->connect_errno );
        }

        // $sql = construct_sql( $sql, $sort_field, $sort_order );
        $sql = "SELECT ClientID, ClientName, ClientAddress FROM Clients";
     
        $result = $conn->query( $sql );

        echo "<table><thead>";
            display_query_header( $result );
        echo "</thead><tbody>";
            display_query_rows( $result );
        echo "</tbody></table>";

        $conn->close();

        /********************************************************/ 
        function show_report( $conn ) {
            if ( isset( $_GET[ "sort_field" ] ) ) {
                $sort_field = $_GET[ "sort_field" ];
                $sort_order = $_GET[ "sort_order" ];
                
                $sort_order == 'DESC' ? $sort_order = 'ASC' : $sort_order = 'DESC';
            } else {
                $sort_order = 'ASC';
                $sort_field = 1;
            }
            $sql = construct_sql( $sql, $sort_field, $sort_order );
            display_query( $conn, $sql, $sort_order );
        }
        /********************************************************/ 
        function construct_sql( $sql, $sort_field, $sort_order ) {
            $sql = "SELECT ClientID, ClientName, ClientAddress FROM Clients";
            if ( $sort_field ) {
                $sql .= " ORDER BY " . $sort_field;
                $sql .= " " . $sort_order;
            }
            return ( $sql );
        }
        /********************************************************/         
        function display_query( $conn, $sql, $sort_order ) {

        }
        /********************************************************/ 
        function display_query_header( $result ) {
            $field_cnt = $result->field_count;
            for ( $i = 0; $i < $field_cnt; $i++ ) { 
                $field = $result->fetch_field();
                $j = $i + 1;
                echo "<th><a href = ' ?sort_field=$j&sort_order=sort_order' >" . $field->name . "</a></th>";
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