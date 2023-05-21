<?php

    // require 'DB/DbOperationsClass.php';

    class MigrateAndSeedClass
    {

        public function __construct()
        {
            $this->db = (new DbOperationsClass());
        }

        public function migrateAndSeed()
        {
            $this->createUsersTable();
            $this->createItemsTable();
            $this->createItemsHistoryTable();
            $this->createUser();
            $this->db->closeConnection();
            
            echo 'DB ready!';
            // header('Location: /' );
        }

        public function createUsersTable()
        {
            $table = 'users';

            $this->db->dropTableIfExists($table);
            
            $query = "CREATE TABLE $table (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) ,
                password VARCHAR(255) ,
                token VARCHAR(100) ,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";

            return $this->db->anyQuery($query);
        }

        public function createItemsTable()
        {
            $table = 'items';

            $this->db->dropTableIfExists($table);

            $query = "CREATE TABLE $table (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name CHAR(255) ,
                phone CHAR(15) ,
                `key` CHAR(15) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";

            return $this->db->anyQuery($query);

        }

        public function createItemsHistoryTable()
        {
            $table = 'itemsHistory';

            $this->db->dropTableIfExists($table);

            $query = "CREATE TABLE $table (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                item_id BIGINT ,
                previousState TEXT ,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";

            return $this->db->anyQuery($query);
        }

        public function createUser()
        {
            $data = [
                'name' => 'test',
                'password' => password_hash('secret', PASSWORD_DEFAULT),
                'token' => password_hash('user_token', PASSWORD_DEFAULT)
            ];

            return $this->db->store('users', $data);
        }
    } 