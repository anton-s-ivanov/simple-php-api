<?php


    class ItemPolicy
    {
        public function checkAuth($request)
        {
            if(empty($request['user_id']) || empty($request['token'])){
                return false;
            }
            
            $user = (new DbOperationsClass())->show('users', (int)$request['user_id']);

            if(!$user){
                return false;
            } 

            if(!password_verify($request['token'], $user->token)){
                return false;
            }


            return true;
        }
    }