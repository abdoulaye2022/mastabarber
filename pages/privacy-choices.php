<?php
include '../includes/header.php';
?>

<style>
    .privacy-choices-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        background: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .privacy-choices-header {
        background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 40px;
    }

    .privacy-choices-header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .privacy-choices-header p {
        font-size: 1.1em;
        opacity: 0.9;
    }

    .choice-section {
        margin-bottom: 30px;
        padding: 25px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background: #fafafa;
    }

    .choice-section h2 {
        color: #c79e56;
        font-size: 1.4em;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .choice-section h2::before {
        content: "";
        width: 20px;
        height: 20px;
        background: #c79e56;
        border-radius: 50%;
        margin-right: 10px;
    }

    .choice-section h3 {
        color: #333;
        font-size: 1.1em;
        margin: 15px 0 10px 0;
    }

    .choice-section p {
        line-height: 1.6;
        color: #555;
        margin-bottom: 15px;
    }

    .choice-section ul {
        margin-left: 20px;
        margin-bottom: 15px;
    }

    .choice-section li {
        line-height: 1.6;
        color: #555;
        margin-bottom: 8px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .btn-action {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-primary {
        background: #c79e56;
        color: white;
    }

    .btn-primary:hover {
        background: #a67c52;
        color: white;
    }

    .btn-secondary {
        background: white;
        color: #c79e56;
        border: 2px solid #c79e56;
    }

    .btn-secondary:hover {
        background: #c79e56;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .info-box {
        background: #e8f4f8;
        border-left: 4px solid #17a2b8;
        padding: 15px;
        margin: 20px 0;
        border-radius: 5px;
    }

    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
        margin: 20px 0;
        border-radius: 5px;
    }

    .contact-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
        border-left: 4px solid #c79e56;
        margin: 30px 0;
    }

    @media (max-width: 768px) {
        .privacy-choices-header h1 {
            font-size: 2em;
        }

        .privacy-choices-container {
            padding: 20px 15px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            text-align: center;
        }
    }
</style>

<div class="privacy-choices-header">
    <h1>Privacy Choices</h1>
    <p>Manage your privacy preferences and personal data</p>
</div>

<div class="privacy-choices-container">
    <div class="info-box">
        <p><strong>Control your data:</strong> This page allows you to manage your privacy preferences and control the use of your personal data in the MastaBaber application.</p>
    </div>

    <div class="choice-section">
        <h2>1. Notification Management</h2>
        <p>Control the types of notifications you want to receive from MastaBaber.</p>

        <h3>Notification Types:</h3>
        <ul>
            <li><strong>Appointment notifications:</strong> Confirmations, reminders and modifications</li>
            <li><strong>Promotions and offers:</strong> Special offers and discounts</li>
            <li><strong>App updates:</strong> New features and improvements</li>
            <li><strong>Marketing communications:</strong> Newsletters and promotional content</li>
        </ul>

        <div class="action-buttons">
            <a href="mastababer://settings/notifications" class="btn-action btn-primary">Open in App</a>
            <a href="mailto:contact@mastabarber.com?subject=Notification Management" class="btn-action btn-secondary">Contact by Email</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>2. Marketing and Communications</h2>
        <p>Choose how you want to receive our marketing communications.</p>

        <h3>Available Options:</h3>
        <ul>
            <li><strong>Promotional emails:</strong> Special offers and news by email</li>
            <li><strong>SMS marketing:</strong> Promotions and reminders by SMS</li>
            <li><strong>Push notifications:</strong> Promotional alerts in the app</li>
            <li><strong>Personalized ads:</strong> Ads based on your preferences</li>
        </ul>

        <div class="info-box">
            <p><strong>Note:</strong> You can unsubscribe from marketing communications at any time without affecting essential service notifications (appointment confirmations, etc.).</p>
        </div>

        <div class="action-buttons">
            <a href="mastababer://settings/marketing" class="btn-action btn-primary">Manage in App</a>
            <a href="mailto:contact@mastabarber.com?subject=Marketing Unsubscribe" class="btn-action btn-secondary">Unsubscribe</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>3. Cookies and Tracking Management</h2>
        <p>Control the use of cookies and tracking technologies in our application.</p>

        <h3>Cookie Types:</h3>
        <ul>
            <li><strong>Essential cookies:</strong> Necessary for app functionality</li>
            <li><strong>Performance cookies:</strong> Improve performance and user experience</li>
            <li><strong>Analytics cookies:</strong> Help us understand app usage</li>
            <li><strong>Marketing cookies:</strong> Personalize your advertising experience</li>
        </ul>

        <div class="warning-box">
            <p><strong>Important:</strong> Disabling certain cookies may affect optimal app functionality.</p>
        </div>

        <div class="action-buttons">
            <a href="mastababer://settings/cookies" class="btn-action btn-primary">Cookie Settings</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>4. Data Sharing Control</h2>
        <p>Manage who your data can be shared with.</p>

        <h3>Sharing Partners:</h3>
        <ul>
            <li><strong>Square (Payments):</strong> Required to process payments (cannot be disabled)</li>
            <li><strong>Analytics services:</strong> To improve our application</li>
            <li><strong>Marketing partners:</strong> For personalized offers</li>
            <li><strong>Support services:</strong> For technical assistance</li>
        </ul>

        <div class="action-buttons">
            <a href="mastababer://settings/data-sharing" class="btn-action btn-primary">Manage Sharing</a>
            <a href="mailto:contact@mastabarber.com?subject=Data Sharing Control" class="btn-action btn-secondary">Request Information</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>5. Access and Management of Your Data</h2>
        <p>Exercise your rights regarding your personal data.</p>

        <h3>Your Rights:</h3>
        <ul>
            <li><strong>Access:</strong> Download a copy of all your data</li>
            <li><strong>Rectification:</strong> Correct or update your information</li>
            <li><strong>Portability:</strong> Export your data to another service</li>
            <li><strong>Limitation:</strong> Restrict the use of certain data</li>
        </ul>

        <div class="action-buttons">
            <a href="mastababer://settings/data-export" class="btn-action btn-primary">Export My Data</a>
            <a href="mastababer://settings/profile-edit" class="btn-action btn-secondary">Edit My Profile</a>
            <a href="mailto:contact@mastabarber.com?subject=Data Access Request" class="btn-action btn-secondary">Request Access</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>6. Account and Data Deletion</h2>
        <p>Permanently delete your account and all associated data.</p>

        <div class="warning-box">
            <p><strong>Warning:</strong> Deleting your account is irreversible. All your data, appointment history and preferences will be permanently deleted.</p>
        </div>

        <h3>What will be deleted:</h3>
        <ul>
            <li>Profile information (name, email, phone)</li>
            <li>Appointment history</li>
            <li>Preferences and settings</li>
            <li>Profile pictures</li>
            <li>App usage data</li>
        </ul>

        <h3>What will be retained:</h3>
        <ul>
            <li>Financial data (in compliance with legal obligations)</li>
            <li>Anonymized data for statistics</li>
        </ul>

        <div class="action-buttons">
            <a href="mastababer://settings/delete-account" class="btn-action btn-danger">Delete My Account</a>
            <a href="mailto:contact@mastabarber.com?subject=Account Deletion Request" class="btn-action btn-secondary">Request by Email</a>
        </div>
    </div>

    <div class="choice-section">
        <h2>7. Location Settings</h2>
        <p>Control the use of your location data.</p>

        <h3>Location Usage:</h3>
        <ul>
            <li><strong>Salon location:</strong> To help you find us</li>
            <li><strong>Nearby services:</strong> Suggestions based on your location</li>
            <li><strong>Traffic analysis:</strong> Service schedule optimization</li>
        </ul>

        <div class="action-buttons">
            <a href="mastababer://settings/location" class="btn-action btn-primary">Location Settings</a>
        </div>
    </div>

    <div class="contact-section">
        <h2>Need Help or Have Questions?</h2>
        <p>Our privacy protection team is here to help you with all your questions regarding your data and privacy preferences.</p>

        <h3>Contact us:</h3>
        <ul>
            <li><strong>Privacy Email:</strong> contact@mastabarber.com</li>
            <li><strong>Phone:</strong> +1 (506) 899 8186</li>
            <li><strong>Online chat:</strong> Available in the app</li>
            <li><strong>Response time:</strong> Within 30 days for privacy requests</li>
        </ul>

        <div class="action-buttons">
            <a href="mailto:contact@mastabarber.com?subject=Privacy Question" class="btn-action btn-primary">Send Email</a>
            <a href="mastababer://support" class="btn-action btn-secondary">Open Support</a>
        </div>
    </div>

    <div class="info-box">
        <p><strong>Update:</strong> This page and our privacy policies are regularly updated. Check our <a href="/privacy-policy" style="color: #c79e56;">complete Privacy Policy</a> for more information.</p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>