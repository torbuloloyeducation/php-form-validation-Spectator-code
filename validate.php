<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_form($post) {

    $values = [
        'name'             => '',
        'email'            => '',
        'phone'            => '',
        'gender'           => '',
        'website'          => '',
        'comment'          => '',
        'password'         => '',
        'confirm_password' => '',
    ];

    $errors = [
        'name'     => '',
        'email'    => '',
        'phone'    => '',
        'gender'   => '',
        'website'  => '',
        'password' => '',
        'confirm'  => '',
        'terms'    => '',
    ];

    $count = isset($post['submit_count']) ? (int)$post['submit_count'] + 1 : 1;

    if (empty($post['name'])) {
        $errors['name'] = 'Name is required';
    } else {
        $values['name'] = test_input($post['name']);
        if (!preg_match("/^[a-zA-Z\s\-']+$/", $values['name'])) {
            $errors['name'] = 'Only letters, spaces, hyphens, and apostrophes allowed';
        }
    }

    if (empty($post['email'])) {
        $errors['email'] = 'Email is required';
    } else {
        $values['email'] = test_input($post['email']);
        if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
    }

    if (empty($post['phone'])) {
        $errors['phone'] = 'Phone number is required';
    } else {
        $values['phone'] = test_input($post['phone']);
        if (!preg_match('/^\+?[0-9 \-]{7,15}$/', $values['phone'])) {
            $errors['phone'] = 'Invalid phone format';
        }
    }

    if (empty($post['gender'])) {
        $errors['gender'] = 'Please select a gender';
    } else {
        $values['gender'] = test_input($post['gender']);
    }

    if (!empty($post['website'])) {
        $values['website'] = test_input($post['website']);
        if (!filter_var($values['website'], FILTER_VALIDATE_URL)) {
            $errors['website'] = 'Invalid URL format';
        }
    }

    if (!empty($post['comment'])) {
        $values['comment'] = test_input($post['comment']);
    }

    if (empty($post['password'])) {
        $errors['password'] = 'Password is required';
    } else {
        $values['password'] = trim($post['password']);
        if (strlen($values['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }
    }

    if (empty($post['confirm_password'])) {
        $errors['confirm'] = 'Please confirm your password';
    } else {
        $values['confirm_password'] = trim($post['confirm_password']);
        if (empty($errors['password']) && $values['confirm_password'] !== $values['password']) {
            $errors['confirm'] = 'Passwords do not match';
        }
    }

    if (!isset($post['terms'])) {
        $errors['terms'] = 'You must agree to the terms and conditions';
    }

    $valid = (implode('', $errors) === '');

    return [
        'values' => $values,
        'errors' => $errors,
        'valid'  => $valid,
        'count'  => $count,
    ];
}
?>
