<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send Message</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .message-form {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input, .form-group textarea, .form-group button {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    .form-group button {
        background-color: #0056b3;
        color: white;
        border: none;
        cursor: pointer;
        margin-top: 20px;
    }
    .form-group button:hover {
        background-color: #004494;
    }
</style>
</head>
<body>

<div class="message-form">
    <form action="save_message.php" method="post">
        <div class="form-group">
            <label for="recruiter_email">Recruiter Email:</label>
            <input type="email" id="recruiter_email" name="recruiter_email" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Send Message</button>
        </div>
    </form>
</div>

</body>
</html>
