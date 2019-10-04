<?php
    if(empty($this->session->userdata('logged_in')) || ($this->session->userdata('logged_in') != TRUE)){
        redirect(base_url());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	
    

    <title>Net Worth Report</title>
</head>
    <style>
    
    
    </style>
<body>
    <div class="container">
        <p>
            <h2 class="center text-primary"><?=strtoupper($name);?></h2>
            <h5 class="center"><?=$email;?></h5>
        </p>
        <br>
        <br>
        <br>
        <div>
            <p>
                <h2>Net Worth Report</h2>
            </p>
            <h4>Below is the total report of your net worth which includes your assets,liabilities and net worth in Nigerian naira(#)</h4>
        </div>

        <div>
            <p>
                <h2>Asset Analysis Report</h2>
            </p>

            <?php if(!empty($assets)):?>

                <table class="table table-bordered table-hover table-responsive">
                <caption>List of Assets</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Asset Name&nbsp;</th>
                            <th scope="col">Asset Value(Naira)&nbsp;</th>
                            <th scope="col">Date Added&nbsp;</th>
                        </tr>
                    </thead>

                    <?php $count=0;?>
                    <?php foreach($assets as $value):?>
                    <?php $count+=1;?>
                    <tr>
                        <th scope="row"><?=$count?></th>
                        <td><?=$value['asset_name']?></td>
                        <td><?=$value['asset_value']?></td>
                        <td><?=$value['date']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>

            <?php else:?>
            <p>
                <h2>You currently have no asset </h2>
            </p> 
            <?php endif;?>
        </div>


        <div>
            <p>
                <h2>Liabilities Analysis Report</h2>
            </p>

            <?php if(!empty($liabilities)):?>

                <table class="table table-bordered table-hover table-responsive">
                <caption>List of Liabilities</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Liability Name&nbsp;</th>
                            <th scope="col">Liability Value(Naira)&nbsp;</th>
                            <th scope="col">Date Added&nbsp;</th>
                        </tr>
                    </thead>

                    <?php $count=0;?>
                    <?php foreach($liabilities as $value):?>
                    <?php $count+=1;?>
                    <tr>
                        <th scope="row"><?=$count?></th>
                        <td><?=$value['liability_name']?></td>
                        <td><?=$value['liability_value']?></td>
                        <td><?=$value['date']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>

            <?php else:?>
            <p>
                <h2>You currently have no Liability </h2>
            </p> 
            <?php endif;?>
        </div>


        <div>
            <p>
                <h2>General Report</h2>
            </p>

            

                <table class="table table-bordered table-hover table-responsive">
                <caption>General Report</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name&nbsp;</th>
                            <th scope="col">Value(Naira)&nbsp;</th>
                            
                        </tr>
                    </thead>

                    
                    <tr>
                        <th scope="row">1</th>
                        <td>Total Asset</td>
                        <td><?=$total_asset?></td>
                        
                    </tr>

                    <tr>
                        <th scope="row">2</th>
                        <td>Total Liability</td>
                        <td><?=$total_liability?></td>
                        
                    </tr>
                    
                    <tr>
                        <th scope="row">3</th>
                        <td>Net Worth</td>
                        <td><?=$net_worth?></td>
                        
                    </tr>
                </table>

            
            
            
        </div>

        <br>
        <br>
        <br>

        <ul class="list-group">
            <li class="list-group-item">The number of assets recorded for <?=strtoupper($name);?> is <h4><?=$asset_count?></h4></li>
            <li class="list-group-item">The number of liability recorded for <?=strtoupper($name);?> is <h4><?=$liability_count?></h4></li>
            <li class="list-group-item">The Net Worth of <?=strtoupper($name);?> is <h2><?=$net_worth;?><sub>NGN</sub></h2></li>
            
        </ul>
   </div> 
</body>
</html>

<?php
    require_once FCPATH. '/vendor/autoload.php';
    $html=ob_get_clean();
    
    
    try {
        $mpdf = new \Mpdf\Mpdf();
        
        $stylesheet = file_get_contents(FCPATH.'/assets/css/pdf_style.css');
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html);
       
        $mpdf->Output();
    } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
        // Process the exception, log, print etc.
        echo $e->getMessage();
    }
?>