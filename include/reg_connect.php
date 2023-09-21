
<?php

function hashPassword($password) {
    // Generate a random salt
    $salt = random_bytes(16);

    // Hash the password using Argon2id
    $options = [
        'memory_cost' => 65536,  // Adjust these values as needed
        'time_cost' => 4,
        'threads' => 4,
    ];
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID, $options);

    return $hashedPassword;
}
///User Registration///

if (isset($_POST['reg_submit'])) {
  $username = $_POST['reg_name'];
  $useremail = $_POST['reg_email'];
  $password = $_POST['reg_pass'];
  $role = $_POST['sel_role'];
  $hashedPassword = hashPassword($password);



if (isset($_POST['reg_email'])) {
$select = $pdo->prepare("select useremail from blos_user where useremail='$useremail'");
                           $select->execute();
                         if ($select->rowCount() > 0) {
                          echo '<script>
                          jQuery(function validation(){
         
                            swal({
                                  title: "Email Already Exist",
                                  icon: "warning",
                                button: "ok",
                                });
                          
                          });
             
                         </script>';
          } else {
            $pdo = new PDO("mysql:host=localhost;dbname=blos_pos", "blos", 'None$upp0rt@123.');
              $insert = $pdo->prepare("insert into blos_user(username,useremail,password,role)values(:name,:email,:pass,:role)");

                $insert->bindParam(':name', $username);
                $insert->bindParam(':email', $useremail);
                $insert->bindParam(':pass', $hashedPassword);
                $insert->bindParam(':role', $role);


            if ($insert->execute()) {

                      echo '<script>
                jQuery(function validation(){
                
                  swal({
                        title: "Account Created",
                        text: "User ' . $username . '",
                        icon: "success",
                      button: "ok",
                      });
                
                });
             
        </script>';
        header('refresh:2;view/dashboard.php');
            } else {
              echo '<script>
         jQuery(function validation(){
         
          swal({
                 title: "Creation Failed",
                icon: "error",
              button: "ok",
              });
         
         });
             
        </script>';
            }

          }
        }
          
        
      



      }


  
?>


