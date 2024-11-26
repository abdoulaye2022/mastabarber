<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer la date envoyée
        $date = $_POST['date'] ?? '';

        // Récupérer les disponibilités non réservées pour la date sélectionnée
        $stmt = $cn->prepare('SELECT id, start_time, end_time FROM availabilities 
                               WHERE date = :date AND status = "available"');
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $availabilities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'availabilities' => $availabilities]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
