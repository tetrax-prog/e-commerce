       <?php 
       require 'config/function.php';
       require 'header.php';
       if(isset($_POST['loggedIn'])){
       ?>
       <script>window.location.href='index.php'</script>
       <?php
    }
       ?>    

     <div class="py-5 bg-light">
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                 <div class="card shadow rounded-4"></div>
                   <div class="p-5">
                    <h4 class="text-dark mb-3">Sign in</h4>
                    <?php alertMessage(); ?>
                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label for="">Enter email Id</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Enter Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="my-3">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign in</button>
                            </div>
                        </form>
                   </div>
                </div>
            </div>
        </div>
    </div>    
            </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>