<?php
 require 'header.php';
?>
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Register</h4>
            <!-- <a href="admins.php" class="btn btn-primary float-end">Back</a> -->
        </div>
        <div class="card-body">
            <form action="login-code.php" method="POST">

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="">Name</label>
                    <input type="text" required name="name" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Email</label>
                    <input type="email" required name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Password</label>
                    <input type="password" required name="password" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="">Phone Number</label>
                    <input type="number" required name="phone" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>
