<?php
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

function get_last_guests($conn, $limit = 10) {
    $sql = "SELECT * FROM tamu ORDER BY tanggal_kunjungan DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function get_category_class($category) {
    switch($category) {
        case 'Instansi': return 'category-instansi';
        case 'Akademisi': return 'category-akademisi';
        case 'Mahasiswa': return 'category-mahasiswa';
        case 'Umum': return 'category-umum';
        default: return 'category-lainnya';
    }
}
?>