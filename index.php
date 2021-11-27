<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Advanced Registration Systtem with Salt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.2.1/sweetalert2.min.css" integrity="sha512-OkYLbkJ4DB7ewvcpNLF9DSFmhdmxFXQ1Cs+XyjMsMMC94LynFJaA9cPXOokugkmZo6O6lwZg+V5dwQMH4S5/3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.2.1/sweetalert2.min.js" integrity="sha512-qsog2Un5vHgtBLsgIIcZcfcRNxUXAswH2TxciIVDcB/reXRm1hFyH5Eb1ubQDUK149uK2HzuC0HFcqtSY5F1gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
        <?php
            //echo 'Good Mornign';
            //Check if the data is comming or not
            if(isset($_GET['registrationform'])){
                echo 'Yes';

                //1. DB Connection Open
                // @ is error surpressor operator
                $conn = @mysqli_connect('localhost',"root",'','ecom2_db') or die('Could not connect');

                // Statement1 or Statement2

                //Always filter/Sanitize the incomming data
                $fname  = mysqli_real_escape_string($conn,$_GET['fname']);
                $email  = mysqli_real_escape_string($conn,$_GET['email']);
                $pass  = mysqli_real_escape_string($conn,$_GET['pass']);
                $cpass  = mysqli_real_escape_string($conn,$_GET['cpass']);
                $agree  = mysqli_real_escape_string($conn,$_GET['agree']);


                //Salt is a random string
                //Create the Salt
                //mt = microtime
                $salt = mt_rand(10,10000);

                echo $salt;

                //123 ---> Hash
                echo '<br>';
                echo $hashed_pass = hash('sha512', $pass);
                echo '<br>';
                echo $hashed_pass = hash('sha512', $salt.$salt.$pass.$salt );

                //2. Build the query
                $sql = " INSERT INTO users_tbl(`fname`,`email`,`password`,`salt`) VALUE ('$fname','$email','$hashed_pass','$salt')";


                //3. Execute the query
                //mysqli_error(connection)
                mysqli_query($conn,$sql) or die('Could not execute the query'.mysqli_error($conn));
               

                //4. Display the result
                echo "<script>Swal.fire({position: 'center-center',icon: 'success',title: 'Your work has been saved',showConfirmButton: false,timer: 1500})</script>";

                //5. DB Connection Close
                mysqli_close($conn);

            }else{
                echo 'NO';
            }
        ?>
        <div class="row">
            <div class="col-6 offset-3">
                <form class="mt-5" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
                    <div class="mb-3">
                        <label for="fname" class="form-label">Fname</label>
                        <input type="text" name="fname" class="form-control" id="fname" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
                        <div id="emaierr" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control" id="pass" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpass" class="form-label">Confirm Password</label>
                        <input type="password" name="cpass" class="form-control" id="cpass" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="agree" value="yes" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Agree ?</label>
                    </div>
                    <button type="submit" name="registrationform" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>