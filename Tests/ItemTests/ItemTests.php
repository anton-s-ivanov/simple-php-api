<?php

    require 'Controllers\ItemController.php';

    class ItemTests
    {

        public function __construct()
        {
            $this->itemController = new ItemController();
            $this->db = (new DbOperationsClass());
            $this->addedElems = [];
        }

        public function test_create_item_success()
        {
            $request = self::fakeItem;
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $res = $this->itemController->store($request);

            if(!empty($res->id)){
                $this->addedElems[] = $res->id;
            }
            
            return empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_create_item_fail_no_key()
        {
            $request = self::fakeItem;
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['key'] = '';
            $res = $this->itemController->store($request);

            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_create_item_fail_not_auth()
        {
            $request = self::fakeItem;
            $request['user_id'] = 1;
            $request['key'] = '';
            $res = $this->itemController->store($request);

            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_show_item_success()
        {
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['id'] = $this->get_random_item_id();
            $res = $this->itemController->show($request);

            return !empty($res->id) && empty($res->errors) ? 'ok' : 'failed' ;   
        }

        public function test_show_item_fail_not_auth()
        {
            $request['user_id'] = 1;
            $request['id'] = $this->get_random_item_id();
            $res = $this->itemController->show($request);

            return empty($res->id) && !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_show_item_fail_no_id()
        {
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $res = $this->itemController->show($request);

            return empty($res->id) && !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_show_item_fail_not_existing_id()
        {
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['id'] = '1235657876070856';
            $res = $this->itemController->show($request);

            return empty($res->id) && empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_update_item_success()
        {
            $request = self::fakeItem;
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['id'] = $this->get_random_item_id();
            $request['name'] = 'new name';
            $res = $this->itemController->update($request);

            return empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_update_item_fail_not_auth()
        {
            $request['user_id'] = 1;
            $request['id'] = $this->get_random_item_id();
            $request['name'] = 'new name';
            $res = $this->itemController->update($request);
            
            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_update_item_fail_validation_long_data()
        {
            $request = self::fakeItem;
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['id'] = $this->get_random_item_id();
            $request['phone'] = 'sigbnkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk';
            $res = $this->itemController->update($request);
            
            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_delete_item_success()
        {
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $request['id'] = $this->get_random_item_id();
            $res = $this->itemController->delete($request);

            return empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_delete_item_failed_not_auth()
        {
            $request['user_id'] = 1;
            $request['id'] = $this->get_random_item_id();
            $res = $this->itemController->delete($request);

            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function test_delete_item_fail_no_id()
        {
            $request['user_id'] = 1;
            $request['token'] = 'user_token';
            $res = $this->itemController->delete($request);

            return !empty($res->errors) ? 'ok' : 'failed' ;
        }

        public function get_random_item_id()
        {
            $query = "SELECT * FROM `items` LIMIT 1";
            $res = $this->db->anyQuery($query);
            $id = $res->fetch_assoc()['id'];

            return $id;
        }

        public function dbSeedItems()
        {
            for($i=0; $i<3; $i++){
                $res = (new DbOperationsClass())->store('items', self::fakeItem);
                $this->addedElems[] = $res->id;
            }
        }

        public function removeAddedElems()
        {
            foreach($this->addedElems as $addedElem){
                $this->db->delete('items', $addedElem);
            }
        }       

        const fakeItem = [
            'name' => 'swgwbttbn',
            'phone' => 'sdgerbttn',
            'key' => 'sgnhproj'
        ];
    }
    