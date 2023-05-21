<?php

require 'Auth\ItemPolicy.php';
require 'Validators\ItemValidator.php';


class ItemController

{
    public function __construct()
    {
        $this->table = 'items';
        $this->db = (new DbOperationsClass());
        $this->policy = (new ItemPolicy());
        $this->validator = (new ItemValidator());
        $this->response = (new Responses());
    }

    public function store($request)
    {
        if(!$this->policy->checkAuth($request)){
            return $this->response->notAuth();
        }

        $validated = $this->validator->validateItem($request);
        if(!$validated){
            return $this->response->notValidated();
        }

        return $this->db->store($this->table, $validated);
    }

    public function update($request)
    {
        if(!$this->policy->checkAuth($request)){
            return $this->response->notAuth();
        }

        $validated = $this->validator->validateItem($request);
        if(!$validated){
            return $this->response->notValidated();
        }

        if(empty($request['id'])){
            return $this->response->notValidated();
        }

        if(!$this->db->show($this->table, $request['id'])){
            return $this->response->notValidated();
        }
        
        $itemHistory = $this->saveHistory($request['id']);
        return $this->db->update($this->table, $validated);
    }

    public function show($request)
    {
        if(!$this->policy->checkAuth($request)){
            return $this->response->notAuth();
        }

        if(empty($request['id'])){
            return $this->response->notValidated();
        }

        return $this->db->show($this->table, $request['id']);
    }

    public function delete($request)
    {
        if(!$this->policy->checkAuth($request)){
            return $this->response->notAuth();
        }

        if(empty($request['id'])){
            return $this->response->notValidated();
        }

        if(!$this->db->show($this->table, $request['id'])){
            return $this->response->notValidated();
        }

        return $this->db->delete($this->table, $request['id']);
    }

    public function saveHistory($id)
    {
        $previousState = $this->db->show($this->table, $id);
        $data = [
            'previousState' => serialize($previousState),
            'item_id' => $id
        ];

        return $this->db->store('itemsHistory', $data);
    }
}