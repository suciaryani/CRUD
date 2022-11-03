<?php

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['nim'])) {
    // Pilih yang akan dihapus
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE nim = ?');
    $stmt->execute([$_GET['nim']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that nim!');
    }
    
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            
            $stmt = $pdo->prepare('DELETE FROM mahasiswa WHERE nim = ?');
            $stmt->execute([$_GET['nim']]);
            $msg = 'You have deleted the contact!';
        } else {
            
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No nim specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Contact #<?=$contact['NIM']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete contact #<?=$contact['NIM']?>?</p>
    <div class="yesno">
        <a href="delete.php?nim=<?=$contact['NIM']?>&confirm=yes">Yes</a>
        <a href="delete.php?nim=<?=$contact['NIM']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>