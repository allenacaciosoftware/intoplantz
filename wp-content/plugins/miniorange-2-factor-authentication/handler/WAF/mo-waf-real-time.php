<?php

function add_to_blacklist($ipaddress,$domain)
{  
    if(get_site_option('mo2f_realtime_ip_block_free'))
    {
        $customer_key   = base64_encode(get_option("mo2f_customerKey"));
        $api_key        = base64_encode(get_option("mo2f_api_key"));
        $ch             = curl_init();
        $url            = MoWpnsConstants::REAL_TIME_IP_HOST.'/realtimeIPBlocking/add_to_blacklist_free.php';


        $postData = array(
        'ipaddress'         => json_encode($ipaddress),
        'domain'            => $domain,
        'mo2f_customerKey'  => $customer_key,
        'mo2f_api_key'      =>$api_key
        );



        curl_setopt_array($ch, array(
         CURLOPT_URL => $url, 
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POST => true,
         CURLOPT_SSL_VERIFYHOST => 0,
         CURLOPT_SSL_VERIFYPEER => 0,
         CURLOPT_POSTFIELDS => $postData
        ));

        $output = curl_exec($ch);
        curl_close($ch);
        
        if($output == 'SUCCESS')
        {
            $added_ipaddress = get_site_option('mo2f_added_ips_realtime');
            
            for($i=0;$i<sizeof($ipaddress);$i++)
            {
                $added_ipaddress .= $ipaddress[$i].',';
            }
            update_site_option('mo2f_added_ips_realtime',$added_ipaddress);
    
        }
    }
}