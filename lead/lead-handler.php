<?php

function sendMessageToChat($botToken, $chatId, $data) {
    $apiUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";

    $message = "Phone: {$data['phone']}\n";
    $message .= "Model: {$data['model']}\n";
    $message .= "URL: {$data['url']}\n";
    $message .= "Date and Time: {$data['date']}\n";
    $message .= "User Agent: {$data['user_agent']}\n";
    $message .= "IP Address: {$data['ip_address']}";

    $params = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    
    // Create a CURL resource
    $ch = curl_init($apiUrl);
    
    // Set CURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute the request
    $response = curl_exec($ch);
    
    // Check for any errors
    if ($response === false) {
        $error = curl_error($ch);
        // Handle the error accordingly
        return $error;
    }
    
    // Close CURL resource
    curl_close($ch);

    return 200;
}

?>


<?php 

function handle_add_lead() {
    // verify nonce
    if (!isset($_POST['cpt_nonce']) || !wp_verify_nonce($_POST['cpt_nonce'], 'add_lead')) {
        die('Permission denied');
    }

    $data = array(
        'post_title' => sanitize_text_field($_POST['phone']),
        'post_type' => 'leads',
        'post_status' => 'publish',
        'post_name' => sanitize_text_field($_POST['phone']),
    );
    $post_id = wp_insert_post($data);

    // Custom fields
    add_post_meta($post_id, 'Model', sanitize_text_field($_POST['model']));
    add_post_meta($post_id, 'Date and Time', date('Y-m-d H:i:s'));
    add_post_meta($post_id, 'URL from where it was submitted', esc_url($_POST['url']));
    add_post_meta($post_id, 'User Agent', sanitize_text_field($_POST['user_agent']));
    add_post_meta($post_id, 'IP Address', sanitize_text_field($_POST['ip_address']));

    // TELEGRAM

    $botToken = '';
    $chatId = '';
    $messageData = array(
        'phone' => sanitize_text_field($_POST['phone']),
        'model' => sanitize_text_field($_POST['model']),
        'url' => esc_url($_POST['url']),
        'date' => date('Y-m-d H:i:s'),
        'user_agent' => sanitize_text_field($_POST['user_agent']),
        'ip_address' => sanitize_text_field($_POST['ip_address'])
    );

    $telResponse = sendMessageToChat($botToken, $chatId, $messageData);

    if ($telResponse == 200) {
        // response
        echo json_encode(array(
          'message' => 'success',
          // 'link' => get_permalink($post_id),
        ));
        return;
    }

    echo json_encode(array(
      'message' => $telResponse,
    ));
}

add_action('admin_post_add_lead', 'handle_add_lead');
add_action('admin_post_nopriv_add_lead', 'handle_add_lead');

?>