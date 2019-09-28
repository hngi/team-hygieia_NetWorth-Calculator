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


                $result=$this->auth_model->find_user($this->session->userdata('user_id'));
                $result2=$this->auth_model->find_asset($this->session->userdata('user_id'));
                $result3=$this->auth_model->find_liability($this->session->userdata('user_id'));

                if($result==FALSE){

                    redirect(base_url());
                }

                if($result2==FALSE){

                    $asset_count=0;
                }else{
                    $asset_count=count($result2);
                }

                if($result3!==FALSE){

                    $total_liability='';
                    foreach ($result3 as  $value) {
                        
                        $total_liability+=$value['liability_value'];
                    }
                    $liability_count=count($result3);
                }else{

                    $total_liability=0;
                    $liability_count=0;
                }

                $data=[
                    'name'=>$result[0]['name'],
                    'email'=>$result[0]['email'],
                    'liabilities'=>$result3,
                    'total_liability'=>$total_liability,
                    'asset_count'=>$asset_count,
                    'liability_count'=>$liability_count
                ];

                $this->load->view('liability',$data);

            }
        }


        public function add_liability(){

            if(!($this->session->userdata('logged_in')) || empty($this->session->userdata('user_id'))){
    
                redirect(base_url());
                
            }else{

                if(empty($this->input->post('liability_name')) || empty($this->input->post('liability_value')) || !(is_numeric($this->input->post('liability_value')))){

                    $data=[
                        'success'=>'',
                        'error'=>'Invalid input'
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
                            redirect(base_url().'liabilities');
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