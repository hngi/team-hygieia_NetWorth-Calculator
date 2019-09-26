<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

    class Liabilities extends CI_Controller{


        public function _construct(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }
        }

        public function index(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }else{

                $this->load->view('liability');

            }
        }


        public function add_liability(){

            if(!($this->session->userdata('logged_in')) || empty($this->session->userdata('user_id'))){
    
                redirect(base_url());
                
            }else{

                if(empty($this->input->post('liability_name')) || empty($this->input->post('liability_value')) || !(is_numeric($this->input->post('liability_value')))){

                    $data=[
                        'success'=>'Invalid input',
                        'error'=>''
                    ];
                    
                    echo json_encode($data);

                }else{

                    $value=$this->input->post('liability_value');
                    $name=$this->input->post('liability_name');
                    $user_id=$this->session->userdata('user_id');

                    
                    $check=$this->auth_model->check_if_liability_exists($user_id,$name);

                    if($check==FALSE){
                    if($this->auth_model->add_liability_to_db($user_id,$name,$value)){

                        $data=[
                            'success'=>'Liability added Sccessfully',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);
                    }else{

                        $data=[
                            'success'=>'Liability addition unsuccessful',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);
                    }
                }else{

                    $data=[
                        'success'=>'',
                        'error'=>'The Liability already exists'
                    ];
                    
                    echo json_encode($data);

                }
                }

            }

        }



        public function remove_liability(){

            if(!($this->session->userdata('logged_in')) || empty($this->session->userdata('user_id'))){
    
                redirect(base_url());
                
            }else{


                if(empty($this->input->post('liability_name'))  || empty($this->session->userdata('user_id'))){

                    $data=[
                        'success'=>'Invalid input',
                        'error'=>''
                    ];
                    
                    echo json_encode($data);

                }else{

                    $name=$this->input->post('liability_name');
                    $user_id=$this->session->userdata('user_id');

                    
                    $check=$this->auth_model->check_if_liability_exists($user_id,$name);
                    if($check){
                        if($this->auth_model->remove_liability($name,$user_id)){

                            $data=[
                                'success'=>'Liability removed Sccessfully',
                                'error'=>''
                            ];
                            
                            echo json_encode($data);
                        }else{

                            $data=[
                                'success'=>'Liability removal unsuccessful',
                                'error'=>''
                            ];
                            
                            echo json_encode($data);
                        }

                
                
                    }else{

                        $data=[
                            'success'=>'Liability does not exist',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);

                    }
                }
    }
}
    }
?>