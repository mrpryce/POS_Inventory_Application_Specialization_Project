<?php
// Check CSRF token validity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        
        $stmt = $pdo->prepare("DELETE FROM blos_user WHERE userid = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
   

    if ($stmt->execute()) {
        echo '<script>
        jQuery(function validation(){
        
         swal({
                title: "Delected",
                text: "User ' . $id. '",
               icon: "success",
             button: "ok",
             });
        
        });
            
       </script>';
    } else {
        echo '<script>
        jQuery(function validation(){
        
         swal({
                title: "Error Delecting User",
                text: "User ' . $id . '",
               icon: "error",
             button: "ok",
             });
        
        }); </script>';
}
    }

}
      
?>