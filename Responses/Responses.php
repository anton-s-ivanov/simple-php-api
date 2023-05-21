<?php

    class Responses
    {
        public function notAuth()
        {
            http_response_code(403);
            return (object)['errors' => ['auth failed']];
        }

        public function notValidated()
        {
            http_response_code(422);
            return (object)['errors' => ['wrong input data']];
        }

        public function notFound()
        {
            http_response_code(404);
            return (object)['errors' => ['not found']];
        }

        public function wrongRequestMethod()
        {
            http_response_code(405);
            return (object)['errors' => ['wrong request method']];
        }
    }