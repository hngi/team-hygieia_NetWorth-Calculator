<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

    class Asset extends CI_Controller{


        public function _construct(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }
        }

        public function overview(){
            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }else{
                $result=$this->auth_model->find_user($this->session->userdata('user_id'));
                $result2=$this->auth_model->find_asset($this->session->userdata('user_id'));
                $result3=$this->auth_model->find_liability($this->session->userdata('user_id'));

                if($result==FALSE  ){
                    redirect(base_url());
                }

                if($result2!==FALSE){
                    
                    $total_asset='';
                    foreach ($result2 as  $value) {
                        
                        $total_asset+=$value['asset_value'];
                    }
                    $asset_count=count($result2);

                }else{
                    $total_asset=0;
                    $asset_count=0;
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
                    'total_asset'=>$total_asset,
                    'asset_count'=>$asset_count,
                    'liability_count'=>$liability_count,
                    'total_liability'=>$total_liability,
                    'net_worth'=>($total_asset-$total_liability)
                ];
                $this->load->view('overview',$data);
            }
        }
        public function index(){

            if(!($this->session->userdata('logged_in'))){
    
                redirect(base_url());
                
            }else{
                $result=$this->auth_model->find_user($this->session->userdata('user_id'));
                $result2=$this->auth_model->find_asset($this->session->userdata('user_id'));
                $result3=$this->auth_model->find_liability($this->session->userdata('user_id'));

                if($result==FALSE  ){
                    redirect(base_url());
                }

                if($result3==FALSE){
                    $liability_count=0;
                }else{
                    $liability_count=count($result3);
                }

                if($result2!==FALSE){
                    
                    $total_asset='';
                    foreach ($result2 as  $value) {
                        
                        $total_asset+=$value['asset_value'];
                    }
                    $asset_count=count($result2);

                }else{
                    $total_asset=0;
                    $asset_count=0;
                }

                
                $data=[
                    'name'=>$result[0]['name'],
                    'email'=>$result[0]['email'],
                    'assets'=>$result2,
                    'total_asset'=>$total_asset,
                    'asset_count'=>$asset_count,
                    'liability_count'=>$liability_count
                ];
                $this->load->view('asset',$data);

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
                        'success'=>$this->input->post('asset_name'),
                        'error'=>'Invalid input'
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
                            redirect(base_url().'asset');
                            
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


            public function generate_report(){
                if(!($this->session->userdata('logged_in'))){

                    redirect(base_url());
                }else{

                    if(empty($this->session->userdata('user_id'))){
                        redirect(base_url());

                    }else{

                        $result=$this->auth_model->find_user($this->session->userdata('user_id'));
                        $result2=$this->auth_model->find_asset($this->session->userdata('user_id'));
                        $result3=$this->auth_model->find_liability($this->session->userdata('user_id'));
        
                        if($result==FALSE){
                            redirect(base_url());
                        }
        
                        if($result2!==FALSE){
                            
                            $total_asset='';
                            foreach ($result2 as  $value) {
                                
                                $total_asset+=$value['asset_value'];
                            }
                            $asset_count=count($result2);
        
                        }else{
                            $total_asset=0;
                            $asset_count=0;
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
                            'total_asset'=>$total_asset,
                            'asset_count'=>$asset_count,
                            'liability_count'=>$liability_count,
                            'total_liability'=>$total_liability,
                            'net_worth'=>($total_asset-$total_liability),
                            'assets'=>$result2,
                            'liabilities'=>$result3
                        ];
                        $this->load->view('networth_report',$data);
                    }
                    }
                }
            
    }

?>