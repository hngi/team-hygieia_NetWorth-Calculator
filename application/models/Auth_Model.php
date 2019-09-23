<?php
    



    class Auth_model extends CI_Model{

        public function check_if_user_exists($name,$email){

            $query=$this->db->get_where('users',['name'=>$name,'email'=>$email]);

            if($query->result_array()==NULL){
                return FALSE;
            }else{
                return TRUE;
            }
        }

        public function register_user($user_id,$name,$password,$email){

            $data=[
                'user_id'=>$user_id,
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
                
            ];
            $query=$this->db->insert('users',$data);

            if($query){

                return true;
            }else{
                return false;
            }


        }


        public function register_pending_user($name,$user_id,$password,$email,$verification_id){

            $data=[
                'user_id'=>$user_id,
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
                'verification_id'=>$verification_id
            ];

            $query=$this->db->insert('pending_user',$data);

            if($query){

                return true;
            }else{
                return false;
            }
        }

        


        public function login_user($email,$password){

            $query=$this->db->get_where('users',['email'=>$email,'password'=>$password]);

            if ($query->result_array()==NULL) {
                
               
                return FALSE;

            } else {
                
                $result=$query->result_array();
                return $result; 
                

            }
            

        }

        public function check_verification_id($id){

            $query=$this->db->get_where('pending_user',['verification_id'=>$id]);

            if ($query->result_array()==NULL) {
                
               
                return FALSE;

            } else {
                
                $result=$query->result_array();
                return $result; 
                

            }

        }

        public function remove_id($id){

            if($this->db->delete('pending_user',['verification_id'=>$id])){

                return TRUE;
            }else{
                return FALSE;
            }
        }

        

    }




?>