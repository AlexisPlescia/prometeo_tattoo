<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ajusta la ruta según la estructura de tu proyecto

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Capturar los datos del formulario
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
        $size = isset($_POST['subject']) ? trim($_POST['subject']) : ''; // Puede haber duplicados en 'name'
        $zone = isset($_POST['subject_zone']) ? trim($_POST['subject_zone']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';
        $color = isset($_POST['color']) ? trim($_POST['color']) : '';

    // Validación básica
    if (empty($name) || empty($email) || empty($size) || empty($zone) || empty($message)) {    
        die("Error: Todos los campos son obligatorios.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   
        die("Error: El email no es válido.");
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP (Usando Gmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'prometeo.tatto@gmail.com'; // Cambia esto por tu correo
        $mail->Password   = 'password'; // Usa la contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configuración del correo
        $mail->setFrom('tuemail@gmail.com', 'Formulario de Contacto');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('prometeo.tatto@gmail.com'); // Donde recibirás los mensajes

        // Adjuntar imagen si se envía
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES['image']['name']);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $mail->addAttachment($targetFilePath);
            }
        }

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Solicitud de Presupuesto";
        $mail->Body    = "
            <h2>Nueva solicitud de presupuesto</h2>
            <p><strong>Nombre:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>whatsapp:</strong> $whatsapp</p>
            <p><strong>Tamaño Aproximado:</strong> $size</p>
            <p><strong>Zona:</strong> $zone</p>
            <p><strong>Mensaje:</strong> $message</p>
            <p><strong>Color:</strong> " . htmlspecialchars($color) . "</p>
        ";
        
        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
    }
} else {
    die("Acceso denegado.");
}
?>
