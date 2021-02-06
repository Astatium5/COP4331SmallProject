<?php
    class Contact {
        private $uid;
        private $cid;
        private $firstName;
        private $lastName;
        private $phone;
        private $email;
        private $address;
        private $city;
        private $state;
        private $zip;

        public function __construct($uid, $cid, $firstName, $lastName, $phone, $email,
                                    $address, $city, $state, $zip) {
            // $this->uid = $uid;
            // $this->cid = $cid;
            // $this->firstName = $firstName;
            // $this->lastName = $lastName;
            // $this->phone = $phone;
            // $this->email = $email;
            // $this->address = $address;
            // $this->city = $city;
            // $this->state = $state;
            // $this->zip = $zip;

            set_uid($uid);
            set_cid($cid);
            set_firstName($firstName);
            set_lastName($lastName);
            set_phone($phone);
            set_email($email);
            set_address($address);
            set_city($city);
            set_state($state);
            set_zip($zip);
        }

        public function get_uid(){
            return $this->uid;
        }

        public function set_uid($uid) {
            $this->uid = $uid;
        }

        public function get_cid() {
            return $this->cid;
        }
        
        public function set_cid($cid) {
            $this->cid = $cid;
        }

        public function get_firstName() {
            return $this->firstName;
        }

        public function set_firstName($firstName) {
            if (strlen($firstName) <= 30 && $firstName != NULL)
                $this->firstName = $firstName;
            else
                throw new Exception("The first name is too long (more than 30 characters) or not initialized.");
        }

        public function get_lastName() {
            return $this->lastName;
        }

        public function set_lastName($lastName) {
            if (strlen($lastName) <= 30 && $lastName != NULL)
                $this->lastName = $lastName;
            else
                throw new Exception("The last name is too long (more than 30 characters) or not initialized.");
        }


        public function get_phone() {
            return $this->phone;
        }

        public function set_phone($phone) {
            if (strlen($phone) <= 15 && $phone != NULL)
                $this->phone = $phone;
            else
                throw new Exception("The phone number is too long (more than 15 characters) or not initialized.");
        }

        public function get_email() {
            return $this->email;
        }

        public function set_email($email) {
            if (strlen($email) <= 100 && $email != NULL)
                $this->email = $email;
            else
                throw new Exception("The email is too long (more than 20 characters) or not initialized.");
        }
        public function get_address() {
            return $this->address;
        }

        public function set_address($address) {
            if (strlen($address) <= 100 && $address != NULL)
                $this->address = $address;
            else
                throw new Exception("The adress is too long (more than 100 characters) or not initialized.");
        }

        public function get_city() {
            return $this->city;
        }

        public function set_city($city) {
            if (strlen($city) <= 20 && $city != NULL)
                $this->city = $city;
            else
                throw new Exception("The city name is too long (more than 20 characters) or not initialized.");
        }

        public function get_state() {
            return $this->state;
        }

        public function set_state($state) {
            if (strlen($state) <= 20 && $state != NULL)
                $this->sate = $state;
            else
                throw new Exception("The state name is too long (more than 20 characters) or not initialized.");
        }

        public function get_zip() {
            return $this->zip;
        }

        public function set_zip($zip) {
            if (strlen($zip) <= 7 && $zip != NULL)
                $this->zip = $zip;
            else
                throw new Exception("The zip is too long (more than 7 characters) or not initialized. ");
        }
    }
?>