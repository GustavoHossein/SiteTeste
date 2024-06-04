<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica o token reCAPTCHA
    $recaptcha_secret = "6LdPLPApAAAAAMM_lOr6v1DrlWeXIl9boONBxqpp";
    $recaptcha_response = $_POST["g-recaptcha-response"];

    $recaptcha_url = "https://www.google.com/recaptcha/enterprise.js?render=6LdPLPApAAAAABOhn5lD8DLyreTrZwgV5rTpDk_I;
    $recaptcha = json_decode(file_get_contents($recaptcha_url));

    if ($recaptcha->success == false) {
        die("Erro: Por favor, prove que você não é um robô.");
    }

    // Sanitize e validação dos dados do formulário
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Erro: Todos os campos obrigatórios devem ser preenchidos.");
    }

    // Valida o formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erro: Endereço de e-mail inválido.");
    }

    // Envia o e-mail
    $to = "guhossein@outlook.com";
    $subject = "Novo formulário de contato: $subject";
    $body = "Nome: $name\nEmail: $email\nMensagem:\n$message";

    if (mail($to, $subject, $body)) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar a mensagem.";
    }
}
?>
