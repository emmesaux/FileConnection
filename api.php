<?php
// Configurazione del database
$host = 'sql303.infinityfree.com'; // Host fornito da InfinityFree
$user = 'if0_39027395'; // Nome utente fornito da InfinityFree
$password = '************'; // Password fornita da InfinityFree
$database = 'if0_39027395_anxiety_app_db'; // Nome del database fornito da InfinityFree

// Connessione al database
$conn = new mysqli($host, $user, $password, $database);

// Controlla la connessione
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

// Ottieni i dati inviati dall'app Flutter
$action = $_POST['action'];
$email = $_POST['email'];
$password = hash('sha256', $_POST['password']); // Hash della password

if ($action == 'register') {
    // Controlla se l'email esiste già
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        echo json_encode(["success" => false, "error" => "Email già registrata"]);
    } else {
        // Inserisci il nuovo utente
        $insert = $conn->query("INSERT INTO users (email, password) VALUES ('$email', '$password')");
        if ($insert) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Errore durante la registrazione"]);
        }
    }
} elseif ($action == 'login') {
    // Controlla le credenziali
    $checkUser = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
    if ($checkUser->num_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Credenziali non valide"]);
    }
}

// Chiudi la connessione
$conn->close();
?>
