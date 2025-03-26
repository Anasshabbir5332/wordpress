<?php

class AutoTrader_API {
    private $api_key = '';
    private $api_secret = '';
    private $auth_endpoint = 'https://api-sandbox.autotrader.co.uk/authenticate';
    private $stock_endpoint = 'https://api-sandbox.autotrader.co.uk/stock';
    private $bearer_token;
    
    public function authenticate() {
        $data = http_build_query([
            'key' => $this->api_key, 
            'secret' => $this->api_secret 
        ]);
    
        $ch = curl_init($this->auth_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
    
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
    
        if ($http_code !== 200) {
            return 'Failed to authenticate';
        }
    
        $body = json_decode($response, true);
        
        if (isset($body['access_token'])) {
            $this->bearer_token = $body['access_token'];
            return $this->bearer_token;
        }
        
        return 'Failed to authenticate';
    }
    
    public function get_stock_data() {
        if (!$this->bearer_token) {
            $this->authenticate();
        }

        $ch = curl_init($this->stock_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->bearer_token,
            'Content-Type: application/json'
        ]);
    
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
    
        echo "<pre>";
        echo "HTTP Code: " . $http_code . "\n";
        echo "Response: " . $response . "\n";
        echo "Error: " . $error . "\n";
        echo "</pre>";
    
        return $response;
    }

    public function get_bearer_token() {
        return $this->bearer_token;
    }
}

// Example usage
$api = new AutoTrader_API();
$token = $api->authenticate();
echo 'Bearer Token: ' . $token . "<br>";

$stock_data = $api->get_stock_data();
echo 'Stock Data: ' . $stock_data;

?>
