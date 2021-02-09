<?php
    class User {
        private $uid;
        private $firstName;
        private $lastName;
        private $login;
        private $password;

        public function __construct($uid, $firstName, $lastName, $login, $password) {
            // $this->uid = $uid;
            // $this->firstName = $firstName;
            // $this->lastName = $lastName;
            // $this->login = $login;
            // $this->password = $password;

            set_uid($uid);
            set_firstName($firstName);
            set_lastName($lastName);
            set_login($login);
            set_password($password);
        }

        public function get_uid() {
            return $this->uid;
        }

        public function set_uid($uid) {
            $this->uid = $uid;
        }

        public function get_firstName() {
            return $this->firstName;
        }

        public function set_firstName($firstName) {
            if (strlen($login) <= 20 && $firstName != NULL)
                $this->login = $login;
            else
                throw new Exception("The first name is too long (more than 30 characters) or not initialized.");
        }

        public function get_lastName() {
            return $this->lastName;
        }

        public function set_lastName($lastName) {
            if (strlen($login) <= 20 && $lastName != NULL)
                $this->login = $login;
            else
                throw new Exception("The last name is too long (more than 30 characters) or not initialized.");
        }

        public function get_login() {
            return $this->login;
        }

        function set_login($login) {
            if (strlen($login) <= 20 && $login != NULL)
                $this->login = $login;
            else
                throw new Exception("The login is too long (more than 20 characters) or not initialized.");
        }

        public function get_password() {
            return $this->password;
        }

        function set_password($password) {
            if (strlen($password) <= 70 && $password != NULL)
                $this->password = $password;
            else
                throw new Exception("The password is too long (more than 70 characters) or not initialized.");
        }
    }
?>