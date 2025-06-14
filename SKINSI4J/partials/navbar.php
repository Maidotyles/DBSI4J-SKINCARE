<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Maida';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" style="z-index: 1050;">
  <a class="navbar-brand ml-3" href="dashboard.php"><i class="fas fa-store"></i> Kasir Skincare</a>
  <div class="ml-auto mr-3  btn btn-sm btn-light ml-2" >
     <td>
             
            
        </div><a href="profil.php" class="text-dark"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($user) ?> </a>
</td>
</nav>
