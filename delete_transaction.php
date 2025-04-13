<?php
include_once("modeles.php");

if (isset($_POST['id_transaction'])) {
    $id_transaction = $_POST['id_transaction'];
    
    // التحقق من وجود العملية في قاعدة البيانات قبل حذفها
    $query = "DELETE FROM transactions WHERE id_transaction = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_transaction);
    
    if ($stmt->execute()) {
        echo 'success';  // عملية الحذف تمت بنجاح
    } else {
        echo 'error';  // حدث خطأ أثناء الحذف
    }
}
?>
