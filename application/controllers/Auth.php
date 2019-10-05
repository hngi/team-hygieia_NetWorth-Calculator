<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

    class Auth extends CI_Controller{

       

            public function _construct(){
                 header('Access-Control-Allow-Origin: *');
                if($this->session->userdata('logged_in')){
    
                    $data=[
                        'error'=>'',
                        'success'=>'You are already logged in'
                    ];
                    
                    $data=json_encode($data);
                    echo $data;
                    
                }
            }

            public function logout(){

                session_unset();
                session_destroy();
                redirect(base_url());
            }


            public function login(){

                if(!($this->session->userdata('logged_in'))){
                if(empty($this->input->post('email')) || empty($this->input->post('password'))){

                    $this->load->view('login');
                }else{

                    $email=xss_clean($this->input->post('email'));
                    $password=xss_clean($this->input->post('password'));
        
                    $result=$this->auth_model->login_user($email,do_hash($password));

                    if (empty($result)) {
                    
                        $data=[
                            'error'=>'Login not Successful',
                            'success'=>'',
                            
                        ];
                        
                        $data=json_encode($data);
                        echo $data;
                        
        
                    } else {
                        $data=[
                            'success'=>'login Successful',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);
                        $_SESSION['logged_in']=TRUE;
                        $_SESSION['user_id']=$result[0]['user_id'];
                    }
                    
                }

                
            }else{
                $url=base_url().'asset/overview';
                redirect($url);
            }
        }

        public function register(){



            if(empty($this->input->post('name')) || empty($this->input->post('email')) || empty($this->input->post('password'))){
                
                
                $this->load->view('register');
                
                
            }else{

                if($this->input->post('pass')==$this->input->post('password')){

                    $data=[
                        'error'=>'Passwords do not match',
                        'success'=>""
                    ];
                    
                }else{  

                $email=xss_clean($this->input->post('email'));
                $name=xss_clean($this->input->post('name'));
                $password=xss_clean($this->input->post('password'));
                
                if($this->auth_model->check_if_user_exists($name,$email)){

                    $data=[
                        'error'=>'User already exists',
                        'success'=>""
                    ];
                    
                    echo json_encode($data);

                }else{

                    $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789";

                $letters = str_split($abc);
                $user_id = "";
                for ($i=0; $i<=12; $i++) {
                    $user_id .= $letters[rand(0, count($letters)-1)];
                }

                    $verification_id=md5(time());
                    
                    $result=$this->auth_model->register_pending_user($name,$user_id,sha1($password),$email,$verification_id);


                    $to=$email;
                        $subject="Account Verification";
                        $message="
                        <html>

                        Hello,Please click on the link below to verify your account
                        <a href='http://hygieianetworth.000webhostapp.com/auth/verify/". $verification_id."'>click!</a>
                        </html>
                        
                        ";
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


                        if(/*mail($to,$subject,$message,$headers)*/ TRUE){

                            if($result){

                            $data=[
                                'success'=>'Your Account has been created.An email has been sent you to verify your email address',
                                'error'=>""
                            ];
                            
                            echo json_encode($data);
                            
                            }else{

                                $data=[
                                    'error'=>'Internal Server Error',
                                    'success'=>""
                                ];
                                
                                echo json_encode($data);
                            }

                        }else{
                            
                            $data=[
                            'error'=>'Verification Email was not sent',
                            'success'=>""
                        ];
                        
                        echo json_encode($data);
                        }
        


                }
            }
                
        }
    }

    public function verify($verification_id){

            $verification_id=xss_clean($verification_id);

            $result=$this->auth_model->check_verification_id($verification_id);

            if(!empty($result)){
                if($this->auth_model->check_if_user_exists($result[0]['name'],$result[0]['email'])){

                    $data=[
                        'error'=>'User Already Exists',
                        'success'=>""
                    ];
                    
                    echo json_encode($data);

            }else{

                $result=$this->auth_model->register_user($result[0]['user_id'],$result[0]['name'],$result[0]['password'],$result[0]['email']);
                
                if($result){
                    
                    if($this->auth_model->remove_id($verification_id)){

                        $data=[
                            'error'=>'Registration Complete',
                            'success'=>""
                        ];
                        
                        echo json_encode($data);
                    }else{

                        $data=[
                            'error'=>'Error during Registration',
                            'success'=>""
                        ];
                        
                        echo json_encode($data);
                    }
                }else{

                    $data=[
                        'error'=>'Error Registering',
                        'success'=>""
                    ];
                    
                    echo json_encode($data);
                }
            }
            }else{

                $data=[
                    'error'=>'Verification ID is not correct',
                    'success'=>""
                ];
                
                echo json_encode($data);

            }

        
    }

    public function forgot_password(){

        if ($this->input->post('email')==NULL || empty($this->input->post('email')) || $this->input->post('name')==NULL || empty($this->input->post('name'))) {
            
            $this->load->view('forgot');
            
        }
        else {
            
            if($this->auth_model->check_if_user_exists($this->input->post('name'),$this->input->post('email'))){
                $email=$this->input->post('email');
                $password=$this->input->post('password');
                $name=$this->input->post('name');
                $result=$this->db->get_where('users',['email'=>$email])->result_array();
                $uid=$result[0]['user_id'];
                $verification_id=sha1(time());
                
                $to=$email;
                $subject="Password Reset";
                $message="
                    <html>
        
                        Hello, Please click on the link below to reset your password
                        <a href='http://localhost/net_worth/auth/change_password/". $verification_id."'>click!</a>
                        </html>
                        ";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";        
                
                        if (/*mail($to,$subject,$message,$headers)*/TRUE) {
                            $input=[
                                'user_id'=>$uid,
                                'email'=>$email,
                                'verification_id'=>$verification_id,
                                'password'=>do_hash($password)
                            ];
                            $this->db->delete('forgot',['user_id'=>$uid]);
                           $this->db->insert('forgot',$input);
                            $data=[
                                'error'=>'',
                                'success'=>'A verification email has been sent to you'
                            ];

                            echo json_encode($data);
                        }

            }else{
                $data=[
                    'success'=>'',
                    'error'=>"Invalid Credentials"
                ];
                echo json_encode($data);
            }
            
        }
    }

    public function change_password($verification_id){

        if(empty($verification_id) || $verification_id==NULL){
            redirect(base_url());
        }else{
           $query= $this->db->get('forgot',['verification_id'=>$verification_id])->result_array(); 
            //echo json_encode($query);
           if (empty($query) ||$query==NULL) {
               
                redirect(base_url());

           }else{

            $data = array(
                'password' => $query[0]['password']
        );
            session_unset();
            session_destroy();
            $this->db->where('user_id', $query[0]['user_id']);
            $this->db->where('email', $query[0]['email']);
            $result=$this->db->update('users', ['password'=>$query[0]['password']]);
       
            //print_r($query);
            redirect(base_url());

           }
        }
    }
    }
?>