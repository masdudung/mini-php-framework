<?php

Use System\Core\Controller;

class LoginController extends Controller {
    public function showLoginForm() {
        $this->render('login/form.html');
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username == 'admin' && $password == 'password') {
            echo "Login successful!";
        } else {
            echo "Login failed!";
        }
    }

    public function showUser($id) {
        echo "Showing user with ID: $id";
    }

    public function showUserCategory($id, $catId, $ini) {
        echo "Showing user with ID: $id in category: $catId with $ini param";
    }
}

