<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fromemail = filter_var(trim($_POST["fromemail"]), FILTER_SANITIZE_EMAIL);
        $firstname = strip_tags(trim($_POST["firstname"]));
                $firstname = str_replace(array("\r","\n"),array(" "," "),$firstname);
        $lastname = trim($_POST["lastname"]);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $address = trim($_POST["address"]);
        $postal = trim($_POST["postal"]);
        $city = trim($_POST["city"]);
        $pwd = trim($_POST["pwd"]);
        $confpwd = trim($_POST["confpwd"]);

        // Check that data was sent to the mailer.
        if ( empty($firstname) OR empty($fromemail) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = $fromemail;

        // Set the email subject.
        $subject = "New contact from $firstname $lastname";

        // Build the email content.
        $email_content = "First Name: $firstname\n";
        $email_content = "Last Name: $lastname\n";
        $email_content = "Ciudad: $city\n";
        $email_content = "Password: $pwd\n";

        $email_content .= "Email: $email\n\n";
        

        // Build the email headers.
        $email_headers = "From: $firstname <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
