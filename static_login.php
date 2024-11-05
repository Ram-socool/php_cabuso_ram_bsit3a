<?php
    $arrUsersList = [
        'Admin' => [
            'admin' => 'Pass1234',
            'renmark' => 'Pogi1234'
        ],
    
        'Content Manager' => [
            'pepito' => 'manaloto',
            'juan' => 'delacruz'
        ],
    
        'System User' => [
            'pedro' => 'penduko'
        ]
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/custom-login.css">
    <title>LOGIN</title>
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($_POST['btnSignIn'])): ?>
            <?php
                $userType = $_POST['inputUserType'];
                $userUsername = $_POST['inputUserName'];
                $userPassword = $_POST['inputPassword'];

                if (isset($arrUsersList[$userType][$userUsername]) && $arrUsersList[$userType][$userUsername] === $userPassword):
            ?>
                <div class="alert alert-success alert-dismissible fade show" style="max-width: 350px; margin: auto;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    Welcome to the system, <?php echo htmlspecialchars($userUsername); ?>.
                </div>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissible fade show" style="max-width: 350px; margin: auto;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    Incorrect Username / Password.
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body text-center">
            <img id="profile-img" class="profile-img-card mb-3" src="avatar icon.png" alt="Profile Image" style="width: 100px; height: 100px; border-radius: 50%;">
                <h4 class="card-title">Login</h4>
                <form method="post" class="form-signin">
                    <div class="mb-3">
                        <select class="form-select" name="inputUserType" required>
                            <option value="" disabled selected>Select User Type</option>
                            <option value="Admin">Admin</option>
                            <option value="Content Manager">Content Manager</option>  
                            <option value="System User">System User</option>   
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="inputUserName" class="form-control" placeholder="User Name" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnSignIn">Sign in</button>
                </form>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</body>
</html>
