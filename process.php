<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.html');
    exit;
}

require_once 'validate.php';

$result = validate_form($_POST);
$values = $result['values'];
$errors = $result['errors'];
$valid  = $result['valid'];
$count  = $result['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Registration Form</h1>

<?php if ($valid): ?>

    <div class="success">
        <h2>Form submitted successfully</h2>
        <div class="result-row"><span>Name</span>     <span><?= $values['name'] ?></span></div>
        <div class="result-row"><span>Email</span>    <span><?= $values['email'] ?></span></div>
        <div class="result-row"><span>Phone</span>    <span><?= $values['phone'] ?></span></div>
        <div class="result-row"><span>Gender</span>   <span><?= $values['gender'] ?></span></div>
        <?php if (!empty($values['website'])): ?>
        <div class="result-row"><span>Website</span> <span><?= $values['website'] ?></span></div>
        <?php endif; ?>
        <?php if (!empty($values['comment'])): ?>
        <div class="result-row"><span>Comment</span> <span><?= $values['comment'] ?></span></div>
        <?php endif; ?>
        <div class="result-row"><span>Password</span><span>••••••••</span></div>
        <div class="result-row"><span>Attempts</span><span><?= $count ?></span></div>
    </div>

    <a href="form.html">Back to form</a>

<?php else: ?>

    <div class="error-box">
        Please fix the errors below and resubmit.
    </div>

    <form action="process.php" method="POST">

        <input type="hidden" name="submit_count" value="<?= $count ?>">

        <h2>Personal Information</h2>

        <div class="field">
            <label for="name">Full Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" value="<?= $values['name'] ?>">
            <?php if ($errors['name']): ?>
                <div class="error"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" value="<?= $values['email'] ?>">
            <?php if ($errors['email']): ?>
                <div class="error"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="phone">Phone Number <span class="required">*</span></label>
            <input type="tel" id="phone" name="phone" value="<?= $values['phone'] ?>">
            <div class="hint">Digits, spaces, dashes, optional leading +. 7–15 characters.</div>
            <?php if ($errors['phone']): ?>
                <div class="error"><?= $errors['phone'] ?></div>
            <?php endif; ?>
        </div>

        <h2>Gender</h2>

        <div class="field">
            <label>Gender <span class="required">*</span></label>
            <div class="radio-group">
                <label><input type="radio" name="gender" value="Female"  <?= $values['gender']=='Female'  ? 'checked' : '' ?>> Female</label>
                <label><input type="radio" name="gender" value="Male"    <?= $values['gender']=='Male'    ? 'checked' : '' ?>> Male</label>
                <label><input type="radio" name="gender" value="Other"   <?= $values['gender']=='Other'   ? 'checked' : '' ?>> Other</label>
            </div>
            <?php if ($errors['gender']): ?>
                <div class="error"><?= $errors['gender'] ?></div>
            <?php endif; ?>
        </div>

        <h2>Online Presence</h2>

        <div class="field">
            <label for="website">Website (optional)</label>
            <input type="text" id="website" name="website" value="<?= $values['website'] ?>">
            <?php if ($errors['website']): ?>
                <div class="error"><?= $errors['website'] ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="comment">Comment (optional)</label>
            <textarea id="comment" name="comment"><?= $values['comment'] ?></textarea>
        </div>

        <h2>Password</h2>

        <div class="field">
            <label for="password">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" placeholder="Min. 8 characters">
            <?php if ($errors['password']): ?>
                <div class="error"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="confirm_password">Confirm Password <span class="required">*</span></label>
            <input type="password" id="confirm_password" name="confirm_password">
            <?php if ($errors['confirm']): ?>
                <div class="error"><?= $errors['confirm'] ?></div>
            <?php endif; ?>
        </div>

        <h2>Terms</h2>

        <div class="field">
            <div class="checkbox-row">
                <input type="checkbox" id="terms" name="terms" <?= isset($_POST['terms']) ? 'checked' : '' ?>>
                <label for="terms">I agree to the <a href="#">Terms and Conditions</a>.</label>
            </div>
            <?php if ($errors['terms']): ?>
                <div class="error"><?= $errors['terms'] ?></div>
            <?php endif; ?>
        </div>

        <p style="font-size:13px; color:#555; margin-top:8px;">Submission attempts: <?= $count ?></p>

        <input type="submit" value="Resubmit">
        <a href="form.html" style="margin-left:12px; font-size:13px;">Start over</a>

    </form>

<?php endif; ?>

</body>
</html>
