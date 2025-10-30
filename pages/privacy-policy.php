<?php
include '../includes/header.php';
?>

<style>
    .privacy-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        background: white;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .privacy-header {
        background: linear-gradient(135deg, #c79e56 0%, #a67c52 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 40px;
    }

    .privacy-header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .privacy-header p {
        font-size: 1.1em;
        opacity: 0.9;
    }

    .privacy-section {
        margin-bottom: 30px;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .privacy-section:last-child {
        border-bottom: none;
    }

    .privacy-section h2 {
        color: #c79e56;
        font-size: 1.5em;
        margin-bottom: 15px;
        border-left: 4px solid #c79e56;
        padding-left: 15px;
    }

    .privacy-section h3 {
        color: #333;
        font-size: 1.2em;
        margin: 20px 0 10px 0;
    }

    .privacy-section p {
        line-height: 1.6;
        color: #555;
        margin-bottom: 15px;
    }

    .privacy-section ul {
        margin-left: 20px;
        margin-bottom: 15px;
    }

    .privacy-section li {
        line-height: 1.6;
        color: #555;
        margin-bottom: 8px;
    }

    .contact-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #c79e56;
        margin: 30px 0;
    }

    .last-updated {
        text-align: center;
        color: #888;
        font-style: italic;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    @media (max-width: 768px) {
        .privacy-header h1 {
            font-size: 2em;
        }

        .privacy-container {
            padding: 20px 15px;
        }
    }
</style>

<div class="privacy-header">
    <h1>Privacy Policy</h1>
    <p>MastaBaber - Mobile Application</p>
</div>

<div class="privacy-container">
    <div class="privacy-section">
        <h2>1. Introduction</h2>
        <p>At MastaBaber, we respect your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, store and protect your information when you use our mobile application and services.</p>
        <p>By using the MastaBaber application, you agree to the practices described in this privacy policy.</p>
    </div>

    <div class="privacy-section">
        <h2>2. Data We Collect</h2>
        <h3>2.1 Information You Provide Us</h3>
        <ul>
            <li><strong>Account information:</strong> First name, last name, email address, phone number</li>
            <li><strong>Profile information:</strong> Profile picture (optional), service preferences</li>
            <li><strong>Booking information:</strong> Selected services, appointment dates and times</li>
            <li><strong>Payment information:</strong> Processed securely by Square (we do not store your credit card information)</li>
        </ul>

        <h3>2.2 Information Collected Automatically</h3>
        <ul>
            <li><strong>Usage data:</strong> Pages visited, features used, time spent in the application</li>
            <li><strong>Technical information:</strong> Device type, operating system, application version</li>
            <li><strong>Location data:</strong> With your permission, to locate our salon and improve our services</li>
        </ul>
    </div>

    <div class="privacy-section">
        <h2>3. Use of Your Data</h2>
        <p>We use your personal data to:</p>
        <ul>
            <li><strong>Appointment management:</strong> Schedule, confirm and manage your bookings</li>
            <li><strong>Communication:</strong> Send you confirmation notifications, reminders and updates</li>
            <li><strong>Service improvement:</strong> Analyze usage to improve our application and services</li>
            <li><strong>Customer support:</strong> Respond to your questions and resolve issues</li>
            <li><strong>Marketing:</strong> With your consent, send you special offers and news</li>
            <li><strong>Legal compliance:</strong> Meet our legal and regulatory obligations</li>
        </ul>
    </div>

    <div class="privacy-section">
        <h2>4. Sharing Your Data</h2>
        <p>We never sell your personal data. We may share your information only in the following cases:</p>
        <ul>
            <li><strong>Square (payment processor):</strong> To process payments securely</li>
            <li><strong>Oomo (communication service):</strong> To manage and respond to customer phone calls and messages</li>
            <li><strong>Service providers:</strong> Trusted partners who help us operate our application (hosting, notifications)</li>
            <li><strong>Legal compliance:</strong> If required by law or to protect our legal rights</li>
            <li><strong>With your consent:</strong> In any other situation with your explicit permission</li>
        </ul>

        <h3>4.1 Mobile Information and SMS Marketing Protection</h3>
        <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #c79e56; margin-top: 15px;">
            <p><strong>Important Notice:</strong> No mobile information will be shared with third parties for marketing or promotional purposes. All the above categories exclude text messaging originator opt-in data and consent; this information will not be shared with any third parties.</p>
        </div>
    </div>

    <div class="privacy-section">
        <h2>5. Data Storage and Security</h2>
        <h3>5.1 Storage</h3>
        <p>Your data is stored on secure servers located in Canada. We retain your information for as long as necessary to provide you with our services or as required by law.</p>

        <h3>5.2 Security</h3>
        <p>We implement appropriate security measures to protect your data:</p>
        <ul>
            <li>Data encryption in transit and at rest</li>
            <li>Restricted access to personal data</li>
            <li>Intrusion monitoring and detection</li>
            <li>Regular security updates</li>
        </ul>
    </div>

    <div class="privacy-section">
        <h2>6. Your Rights</h2>
        <p>You have the following rights regarding your personal data:</p>
        <ul>
            <li><strong>Access:</strong> Request a copy of your personal data</li>
            <li><strong>Rectification:</strong> Correct or update your information</li>
            <li><strong>Deletion:</strong> Request deletion of your data</li>
            <li><strong>Limitation:</strong> Limit the processing of your data</li>
            <li><strong>Portability:</strong> Receive your data in a structured format</li>
            <li><strong>Opposition:</strong> Object to the processing of your data for certain purposes</li>
            <li><strong>Withdrawal of consent:</strong> Withdraw your consent at any time</li>
        </ul>
        <p>To exercise these rights, contact us using the details provided below.</p>
    </div>

    <div class="privacy-section">
        <h2>7. Notifications and Preferences</h2>
        <p>You can manage your notification preferences directly in the application:</p>
        <ul>
            <li>Appointment notifications (confirmations, reminders)</li>
            <li>Promotional offers and marketing</li>
            <li>Application updates</li>
            <li>Push notifications</li>
        </ul>
        <p>You can disable notifications at any time in your device or application settings.</p>
    </div>

    <div class="privacy-section">
        <h2>8. Cookies and Similar Technologies</h2>
        <p>Our application may use technologies similar to cookies to:</p>
        <ul>
            <li>Remember your preferences</li>
            <li>Improve application performance</li>
            <li>Analyze application usage</li>
        </ul>
        <p>You can manage these preferences in the application settings.</p>
    </div>

    <div class="privacy-section">
        <h2>9. Protection of Minors</h2>
        <p>Our application is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If we discover that a child under 13 has provided us with personal information, we will delete it immediately.</p>
    </div>

    <div class="privacy-section">
        <h2>10. Changes to this Policy</h2>
        <p>We may update this privacy policy from time to time. We will notify you of any significant changes by:</p>
        <ul>
            <li>Publishing the new policy on this page</li>
            <li>Sending you an email notification</li>
            <li>Displaying a notification in the application</li>
        </ul>
        <p>We encourage you to review this policy regularly to stay informed about how we protect your information.</p>
    </div>

    <div class="contact-info">
        <h2>11. Contact Us</h2>
        <p>If you have any questions, concerns or requests regarding this privacy policy or the processing of your personal data, you can contact us:</p>
        <ul>
            <li><strong>Email:</strong> contact@mastabarber.com</li>
            <li><strong>Phone:</strong> +1 (506) 899 8186</li>
            <li><strong>Address:</strong> 95 Millennium Blvd, Suite 207, Moncton, NB E1E 2G7, Canada</li>
            <li><strong>Website:</strong> www.mastabarber.com</li>
        </ul>
        <p>We strive to respond to all requests within 30 days.</p>
    </div>

    <div class="last-updated">
        <p>Last updated: <?= date('F d, Y') ?></p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>