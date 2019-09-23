<?php

    class Auth extends CI_Controller{

        // public function _construct(){

        //     if($this->session->userdata('logged_in')){

        //         $data=[
        //             'error'=>'',
        //             'success'=>'You are already logged in'
        //         ];
                
        //         $data=json_encode($data);
        //         echo $data;
                
        //     }else{

        //         $this->load->view('auth/login');
        //     }

        // }

            // public function index(){

            //     if($this->session->userdata('logged_in')){

            //         $data=[
            //             'error'=>'',
            //             'success'=>'You are already logged in'
            //         ];
                    
            //         $data=json_encode($data);
            //         echo $data;
                    
            //     }else{

            //         $this->load->view('auth/login');
            //     }
            // }

            public function login(){

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
                    
                    $data=json_encode($data);
                    echo $data;
                    $_SESSION['logged_in']=TRUE;
                }
                
            
        }

        public function register(){

            if(empty($this->input->post('name')) || empty($this->input->post('email')) || empty($this->input->post('password'))){
                
                $data=[
                    'error'=>'Invalid Input',
                    'success'=>""
                ];
                //$this->load->view('register',$data);
                echo json_encode($data);
                
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
    }
?>