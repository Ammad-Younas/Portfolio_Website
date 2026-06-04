<?php
require_once __DIR__ . '/../functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_contact_form') {
    $name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        echo json_encode(['success' => false, 'data' => ['message' => 'Please fill in all fields.']]);
        exit;
    }

    if ( ! is_email( $email ) ) {
        echo json_encode(['success' => false, 'data' => ['message' => 'Please provide a valid email address.']]);
        exit;
    }

    $to = 'ammadyounas.tech@gmail.com';
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email;

    $sent = @mail($to, $subject, $body, $headers);

    if ( $sent ) {
        echo json_encode(['success' => true, 'data' => ['message' => 'Thank you! Your message has been sent.']]);
    } else {
        echo json_encode(['success' => false, 'data' => ['message' => 'Failed to send message. Please try again later.']]);
    }
    exit;
}

echo json_encode(['success' => false, 'data' => ['message' => 'Invalid request.']]);
