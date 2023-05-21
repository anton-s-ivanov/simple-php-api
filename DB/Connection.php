<?php

    class Connection
    {
    
        public function db_connect()
        {
            $env = parse_ini_file('.env');
            $db_connection = $env['DB_CONNECTION'];
            $db_host= $env['DB_HOST'];
            $db_port = $env['DB_PORT'];
            $db_database = $env['DB_DATABASE'];
            $db_username = $env['DB_USERNAME'];
            $db_password = $env['DB_PASSWORD'];

            $connection = new mysqli($db_host, $db_username, $db_password, $db_database, $db_port);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            return $connection;
        }
    }
    