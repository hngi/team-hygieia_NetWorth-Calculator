<?php
    



    class Auth_model extends CI_Model{

        public function check_if_user_exists($name,$email){

            $query=$this->db->get_where('users',['name'=>$name]);
             $query2=$this->db->get_where('users',['email'=>$email]);
 
             if($query->result_array()==NULL && $query2->result_array()==NULL){
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

        
        public function add_asset_to_db($user_id,$name,$value){

            $data=[

                'user_id'=>$user_id,
                'asset_name'=>$name,
                'asset_value'=>$value
            ];

            $query=$this->db->insert('assets',$data);

            if($query){

                return true;
            }else{
                return false;
            }
        }


        public function add_liability_to_db($user_id,$name,$value){

            $data=[

                'user_id'=>$user_id,
                'liability_name'=>$name,
                'liability_value'=>$value
            ];

            $query=$this->db->insert('liabilities',$data);

            if($query){

                return true;
            }else{
                return false;
            }
        }

        
        public function remove_liability($name,$user_id){

            if($this->db->delete('liabilities',['liability_name'=>$name,'user_id'=>$user_id])){

                return TRUE;
            }else{
                return FALSE;
            }

        }


        public function remove_asset($name,$user_id){

            if($this->db->delete('assets',['asset_name'=>$name,'user_id'=>$user_id])){

                return TRUE;
            }else{
                return FALSE;
            }

        }

        public function check_if_asset_exists($user_id,$asset){

            
             $query=$this->db->get_where('assets',['user_id'=>$user_id,'asset_name'=>$asset]);
 
             if($query->result_array()==NULL){
                 return FALSE;
             }else{
                 return TRUE;
             }
         }

         public function check_if_liability_exists($user_id,$asset){

            
            $query=$this->db->get_where('liabilities',['user_id'=>$user_id,'liability_name'=>$asset]);

            if($query->result_array()==NULL){
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }




?>