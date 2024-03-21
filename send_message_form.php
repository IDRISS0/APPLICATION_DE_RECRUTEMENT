<?php
// send_message_form.php
$recruiterEmail = $_GET['recruiter_email'] ?? '';
$jobId = $_GET['job_id'] ?? '';

// Simple form for candidate to enter message
echo '<form action="save_message.php" method="post">
        <input type="hidden" name="recruiter_email" value="' . htmlspecialchars($recruiterEmail) . '">
        <input type="hidden" name="job_id" value="' . htmlspecialchars($jobId) . '">
        <textarea name="message" required placeholder="Type your message here..."></textarea>
        <input type="submit" value="Send Message">
      </form>';
?>
