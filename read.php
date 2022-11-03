<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$stmt = $pdo->prepare('SELECT * FROM mahasiswa ORDER BY nim LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num_contacts = $pdo->query('SELECT COUNT(*) FROM mahasiswa')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>Daftar</h2>
	<a href="create.php" class="create-contact">CREATE ACCOUNT</a>
	<table>
        <thead>
            <tr>
                <td>OPSI</td>
                <td>GAMBAR</td>
                <td>NIM</td>
                <td>NAMA</td>
                <td>EMAIL</td>
                <td>JURUSAN</td>
                <td>FAKULTAS</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td class="actions">
                    <a href="update.php?nim=<?=$contact['NIM']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?nim=<?=$contact['NIM']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
                <td><img src="Gambar/<?php echo $contact['Gambar'] ; ?>" width="80"></td>
                <td><?=$contact['NIM']?></td>
                <td><?=$contact['Nama']?></td>
                <td><?=$contact['Email']?></td>
                <td><?=$contact['Jurusan']?></td>
                <td><?=$contact['Fakultas']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>