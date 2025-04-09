<?php
session_start();
include 'login_data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $user_exists = false;
    foreach ($all_users as $user) {
        if ($user['id'] === $id) {
            $user_exists = true;
            break;
        }
    }

    if ($user_exists) {
        echo "<script>
                alert('This ID is already taken. Please choose another.');
                window.location.href = 'registration_form.php';
              </script>";
    } 
    else{
        if($role == 'employee'){
            $employees = json_decode(file_get_contents('employees/employees_data.json'), true) ?? [];
            $employee_exists = false;
            foreach ($employees as $employee) {
                if ($employee['id'] === $id) {
                    $employee_exists = true;
                    $name = $employee['name'];
                    break;
                }
            }
            if ($employee_exists) {
                $name = $employee['name'];
            }
            else {
                echo "<script>
                alert('employee not added by admin yet!');
                window.location.href = 'index.php';
                </script>";
                exit;
            }
        }
    
        $new_user = ['id' => $id, 'role' => $role, 'name' => $name, 'password' => $password];
        $all_users[] = $new_user;
        file_put_contents('users/users_data.json', json_encode($all_users, JSON_PRETTY_PRINT));

        echo "<script>
                alert('Registration successful!');
                window.location.href = 'index.php';
            </script>";
    }
}
?>
