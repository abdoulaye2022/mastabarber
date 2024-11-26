<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    
    try {
        // Récupérer le numéro de téléphone envoyé
        $phone = $_POST['phone'] ?? '';

        // Vérifier si le numéro existe dans la base de données
        $stmt = $cn->prepare('SELECT firstname, lastname, email FROM customers WHERE phone = :phone');
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(['success' => true, 'fullname' => $user['firstname'] . ' ' . $user['lastname'], 'email' => $user['email']]);
        } else {
            echo json_encode(['success' => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
