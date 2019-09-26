<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

    class Asset extends CI_Controller{


        public function _construct(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }
        }

        public function index(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }else{

                $this->load->view('asset');

            }
        }


        public function add_asset(){

            if(!($this->session->userdata('logged_in')) || empty($this->session->userdata('user_id'))){
    
                redirect(base_url());
                
            }else{

                if(empty($this->input->post('asset_name')) || empty($this->input->post('asset_value')) || !(is_numeric($this->input->post('asset_value')))){

                    $data=[
                        'success'=>'Invalid input',
                        'error'=>''
                    ];
                    
                    echo json_encode($data);

                }else{

                    $value=$this->input->post('asset_value');
                    $name=$this->input->post('asset_name');
                    $user_id=$this->session->userdata('user_id');

                    
                    $check=$this->auth_model->check_if_asset_exists($user_id,$name);

                    if($check==FALSE){
                    if($this->auth_model->add_asset_to_db($user_id,$name,$value)){

                        $data=[
                            'success'=>'Asset added Sccessfully',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);
                    }else{

                        $data=[
                            'success'=>'Asset addition unsuccessful',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);
                    }
                }else{

                    $data=[
                        'success'=>'',
                        'error'=>'The asset already exists'
                    ];
                    
                    echo json_encode($data);

                }
                }

            }

        }



        public function remove_asset(){

            if(!($this->session->userdata('logged_in')) || empty($this->session->userdata('user_id'))){
    
                redirect(base_url());
                
            }else{


                if(empty($this->input->post('asset_name'))  || empty($this->session->userdata('user_id'))){

                    $data=[
                        'success'=>'Invalid input',
                        'error'=>''
                    ];
                    
                    echo json_encode($data);

                }else{

                    $name=$this->input->post('asset_name');
                    $user_id=$this->session->userdata('user_id');

                    
                    $check=$this->auth_model->check_if_asset_exists($user_id,$name);
                    if($check){
                        if($this->auth_model->remove_asset($name,$user_id)){

                            $data=[
                                'success'=>'Asset removed Sccessfully',
                                'error'=>''
                            ];
                            
                            echo json_encode($data);
                        }else{

                            $data=[
                                'success'=>'Asset removal unsuccessful',
                                'error'=>''
                            ];
                            
                            echo json_encode($data);
                        }

                
                
                    }else{

                        $data=[
                            'success'=>'Asset does not exist',
                            'error'=>''
                        ];
                        
                        echo json_encode($data);

                    }
                }
    }
}
    }
?>