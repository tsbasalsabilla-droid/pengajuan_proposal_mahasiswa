<?php
// Simple test untuk update status
$host = "localhost";
$user = "root";
$pass = "";
$db = "pengajuan_proposal";

$conn = new mysqli($host, $user, "123", $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lihat semua data proposal
echo "<h3>Data Proposal di Database:</h3>";
$result = $conn->query("SELECT id, nim, judul, status, tanggal FROM pengajuan_proposal ORDER BY id");

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>NIM</th><th>Judul</th><th>Status</th><th>Tanggal</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nim'] . "</td>";
        echo "<td>" . $row['judul'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['tanggal'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test update status untuk ID pertama yang ada
    $first_row = $result->fetch_assoc();
    if ($first_row) {
        $id = $first_row['id'];
        echo "<h3>Test Update Status untuk ID: $id</h3>";
        
        $sql = "UPDATE pengajuan_proposal SET status = 'Disetujui' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Status berhasil diupdate!<br>";
            
            // Cek hasil
            $result2 = $conn->query("SELECT status FROM pengajuan_proposal WHERE id = $id");
            $row2 = $result2->fetch_assoc();
            echo "Status saat ini: " . $row2['status'];
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Tidak ada data proposal di database!";
}

$conn->close();
?>
