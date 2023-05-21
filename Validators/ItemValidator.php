<?php

    class ItemValidator
    {
        public function validateItem($request)
        {
            if(!$validated['id'] = $this->validateId($request))
            return false;

            if(!$validated['name'] = $this->validateName($request))
            return false;

            if(!$validated['phone'] = $this->validatePhone($request))
            return false;

            if(!$validated['key'] = $this->validateKey($request))
            return false;

            return $validated;
        }

        public function validateId($request)
        {
            $validate = empty($request['id']) || $request['id'] == (int)$request['id'];
            return $validate ? $request['id'] ?? true : false;
        }

        public function validateName($request)
        {
            $validate = strlen($request['name']) < 255;
            return $validate ? $request['name'] : false;
        }

        public function validatePhone($request)
        {
            $validate = strlen($request['phone']) < 15;
            return $validate ? $request['phone'] : false;
        }

        public function validateKey($request)
        {
            $validate = strlen($request['key']) > 0 && strlen($request['key']) < 25;
            return $validate ? $request['key'] : false;
        }

    }