<?php

    require 'DB/Connection.php';

    class DbOperationsClass
    {
        public function __construct()
        {
            $this->db_connection = (new Connection())->db_connect();
        }

        public function store($table, $arr)
        {
            $sqlArr = $this->getInsertArr($table, $arr);
                      
            $stmt = $this->db_connection->prepare($sqlArr['prepareQuery']);
            $stmt->bind_param($sqlArr['types'], ...$sqlArr['values']);
            $stmt->execute();

            if(count($stmt->error_list)){
                return (object)['errors' => ['store item failed']];
            }

            return (object)['messages' => ['stored successful'], 'id' => $stmt->insert_id];
        }

        public function update($table, $arr)
        {
            $sqlArr = $this->getUpdateArr($table, $arr);
            $stmt = $this->db_connection->prepare($sqlArr['prepareQuery']);
            $stmt->bind_param($sqlArr['types'], ...$sqlArr['values']);
            $stmt->execute();

            if(count($stmt->error_list)){
                return (object)['errors' => ['update failed']];
            }

            return (object)['messages' => ['updated']];
        }

        public function show($table, $id)
        {
            $stmt = $this->db_connection->prepare("SELECT * FROM $table WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            return (object)$stmt->get_result()->fetch_assoc();
        }

        public function delete($table, $id)
        {
            $stmt = $this->db_connection->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            if(count($stmt->error_list)){
                return (object)['errors' => ['delete failed']];
            }

            return (object)['messages' => ['deleted']];
        }

        public function anyQuery($query)
        {
            $res = $this->db_connection->query($query);
            if(!$res){
                return (object)['errors' => ['query failed']];
            }
            return $res;
            // return $this->executeQuery($query);
        }

        // public function executeQuery($query)
        // {
        //     if(!$this->db_connection->query($query)){
        //         return "Error: " . $this->db_connection->error;
        //     }
        // }

        public function dropTableIfExists($table)
        {
            return $this->db_connection->query("DROP TABLE IF EXISTS $table");
        }

        public function closeConnection()
        {
            $this->db_connection->close();
        }

        public function getInsertArr($table, $arr)
        {
            $i=0;
            $prepareQuery_1 = $prepareQuery_2 = $types = '';
            foreach($arr as $k=>$v){
                if($k==='id' || $k==='user_id'|| ($k==='token' && $table != 'users')) continue;
                $sep = ++$i === 1 ? '' : ', ';
                $prepareQuery_1 = $prepareQuery_1.$sep.'`'.$k.'`';
                $prepareQuery_2 = $prepareQuery_2.$sep.'?';
                $types = $types.'s';
                $values[] = $v;
            }
            
            $sqlArr['prepareQuery'] = "INSERT INTO $table ($prepareQuery_1) VALUES ($prepareQuery_2)";
            $sqlArr['types'] = $types;
            $sqlArr['values'] = $values;

            return $sqlArr;
        }

        public function getUpdateArr($table, $arr)
        {
            $i=0;
            $prepareQuery = $types = '';
            foreach($arr as $k=>$v){
                if($k==='id' || $k==='user_id' || ($k==='token' && $table != 'users')) continue;
                $sep = ++$i === 1 ? '' : ', ';
                $prepareQuery = $prepareQuery.$sep.'`'.$k.'`=?';
                $types = $types.'s';
                $values[] = $v;
            }

            $prepareQuery = $prepareQuery.$sep.'`updated_at`=?';
            $values[] = date("Y-m-d H:i:s");
            $types = $types.'s';
            
            $id = $arr['id'];
            $sqlArr['prepareQuery'] ="UPDATE $table SET $prepareQuery  WHERE id=$id";
            $sqlArr['types'] = $types;
            $sqlArr['values'] = $values;

            return $sqlArr;
        }
    }