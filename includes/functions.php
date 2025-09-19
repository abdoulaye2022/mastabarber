<?php
require_once (__DIR__ . '/../vendor/autoload.php');

function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

function validatePhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[\s\-\(\)]+/', '', $phoneNumber);

    $pattern = '/^\+?[0-9]{5,15}$/';

    if (preg_match($pattern, $phoneNumber)) {
        return true;
    } else {
        return false;
    }
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function genererCreneauxAvecPause($heure_debut, $heure_fin, $duree, $pauses = []) {
    $creneaux = [];
    $debut = strtotime($heure_debut);
    $fin = strtotime($heure_fin);

    while ($debut + $duree * 60 <= $fin) {
        $creneau_fin = $debut + $duree * 60;

        // Vérifier si le créneau est dans une pause
        $est_dans_une_pause = false;
        foreach ($pauses as $pause) {
            $pause_debut = strtotime($pause['debut']);
            $pause_fin = strtotime($pause['fin']);

            if (($debut >= $pause_debut && $debut < $pause_fin) || 
                ($creneau_fin > $pause_debut && $creneau_fin <= $pause_fin)) {
                $est_dans_une_pause = true;
                break;
            }
        }

        if (!$est_dans_une_pause) {
            $creneaux[] = [
                'heure_debut' => date('H:i', $debut),
                'heure_fin' => date('H:i', $creneau_fin),
            ];
        }

        $debut = $creneau_fin; // Passer au prochain créneau
    }

    return $creneaux;
}

