@extends('layouts.legal')

@section('title', 'Privacy Policy')
@section('meta-description', 'How Hishabiz collects, uses and protects your information, including Google Login data and your business records. Read the Hishabiz Privacy Policy.')

@section('legal-content')
<p>This Privacy Policy explains how Hishabiz ("<strong>Hishabiz</strong>", "we", "us") collects, uses and shares information when you use our business management software at <a href="{{ url('/') }}">hishabiz.com</a> (the "Service"). By using the Service you acknowledge this Policy. If you do not agree, please do not use the Service.</p>

<div class="lg-toc">
  <strong>Contents</strong>
  <ol>
    <li><a href="#collect">Information we collect</a></li>
    <li><a href="#use">How we use information</a></li>
    <li><a href="#tenant">Business data and tenant separation</a></li>
    <li><a href="#google">Google Login</a></li>
    <li><a href="#security">Security and backups</a></li>
    <li><a href="#sharing">Sharing and service providers</a></li>
    <li><a href="#payments">Subscriptions and payments</a></li>
    <li><a href="#retention">Retention and deletion</a></li>
    <li><a href="#rights">Your rights and responsibilities</a></li>
    <li><a href="#cookies">Cookies and sessions</a></li>
    <li><a href="#children">Children's privacy</a></li>
    <li><a href="#changes">Changes to this Policy</a></li>
    <li><a href="#contact">Contact us</a></li>
  </ol>
</div>

<h2 id="collect">1. Information we collect</h2>

<h3>Account and business information</h3>
<ul>
  <li>Owner name, email address and mobile number.</li>
  <li>Business name and business type, and the name of your main branch.</li>
  <li>Your password, which we store only in hashed (not readable) form. If you sign up with Google, we generate a random password that is never shown to anyone.</li>
  <li>Your role (for example owner or employee), account status and language preference.</li>
  <li>Details of employees you invite, such as their name, email and mobile number.</li>
</ul>

<h3>Business records you enter</h3>
<p>Products, categories, stock levels, sales, purchases, returns, damaged stock, customers, suppliers, expenses, due and payment records, invoices, reports, notifications and settings. This includes personal details of your own customers and suppliers (such as names, phone numbers and amounts owed) that you choose to record.</p>

<h3>Login and verification information</h3>
<ul>
  <li>Email verification codes (short-lived) and password-reset tokens.</li>
  <li>Whether your email has been verified.</li>
</ul>

<h3>Google account information</h3>
<p>If you choose "Continue with Google", we receive from Google your name, email address, whether Google has verified that email, and your Google account identifier. See section 4.</p>

<h3>Technical and marketing information</h3>
<ul>
  <li><strong>IP address</strong>: we store the IP address from your most recent registration or login on your user record.</li>
  <li><strong>Marketing attribution</strong>: when you arrive on our landing, login or registration pages with tracking parameters (for example UTM campaign tags), we store those parameters, the landing page, the referring site and your IP address. If you then register or log in, this record is linked to your account so we can understand which campaigns bring users.</li>
  <li><strong>Analytics</strong>: we use Google Analytics, which may collect information such as pages viewed, approximate location, browser, operating system and device type through cookies or similar technologies.</li>
  <li><strong>Feedback</strong>: anything you send us through the in-app or website feedback form.</li>
</ul>

<h2 id="use">2. How we use information</h2>
<ul>
  <li>To create and operate your account and your business workspace, and to provide the features of the Service.</li>
  <li>To authenticate you, keep you signed in, verify your email and let you reset your password.</li>
  <li>To send service emails such as verification codes, password resets and employee invitations.</li>
  <li>To apply the limits of your subscription plan.</li>
  <li>To respond to support requests and feedback.</li>
  <li>To measure and improve the Service and our marketing.</li>
  <li>To detect, prevent and investigate misuse, fraud or security problems.</li>
  <li>To comply with legal obligations.</li>
</ul>
<p>We do not sell your personal information or your business records.</p>

<h2 id="tenant">3. Business data and tenant separation</h2>
<p>Each business registered on Hishabiz is a separate "tenant". Business records are stored with the identifier of the business they belong to, and the application restricts queries to the business of the signed-in user, so users of one business are not shown another business's records. Employees you invite can access your business's data according to the role and permissions you give them. You are responsible for choosing who you invite.</p>
<p>The business records you enter belong to you. We process them on your behalf to provide the Service.</p>
<p>Authorised Hishabiz personnel may access stored data where necessary to operate the Service, provide support you request, or investigate security issues.</p>

<h2 id="google">4. Google Login</h2>
<ul>
  <li>Google Login is optional. You can still register and log in with email or mobile number and password.</li>
  <li>We request only basic profile information (name, email address and Google account identifier). We do not request access to your Gmail, Google Drive, contacts, calendar or other Google data.</li>
  <li>We use your Google email only after Google confirms it is verified. We store your Google account identifier on your user record to recognise you on later logins.</li>
  <li>We do not store the access token Google issues for the sign-in.</li>
  <li>If you start Google sign-up but do not finish entering your business details, we keep your verified Google name, email and identifier temporarily (up to 14 days) so you can resume. After you complete registration, or when that period ends and the record is no longer usable, it is not used for anything else.</li>
  <li>If an account already exists with the same email and a password, we ask you to confirm that password before Google is linked to it. We never link accounts silently.</li>
  <li>Our use of information received from Google APIs follows the <a href="https://developers.google.com/terms/api-services-user-data-policy" target="_blank" rel="noopener">Google API Services User Data Policy</a>, including its Limited Use requirements.</li>
  <li>You can review or revoke Hishabiz's access to your Google account at any time in your <a href="https://myaccount.google.com/permissions" target="_blank" rel="noopener">Google Account permissions</a>.</li>
</ul>

<h2 id="security">5. Security and backups</h2>
<p>We use measures that are built into the Service, including:</p>
<ul>
  <li>Hashed password storage.</li>
  <li>Encrypted connections (HTTPS) for the website.</li>
  <li>Email verification and rate limits on sensitive actions such as password reset.</li>
  <li>Tenant-level restriction of business records, as described in section 3.</li>
</ul>
<p>No online service can be completely secure, and we cannot guarantee absolute security. We do not currently promise a specific backup schedule or recovery time for your data, and you should keep your own copies of important records (for example, by using the export and report features where available). Keep your password confidential and tell us immediately if you suspect unauthorised access.</p>

<h2 id="sharing">6. Sharing and service providers</h2>
<p>We share information only as described below:</p>
<ul>
  <li><strong>Hosting and infrastructure providers</strong> that store and run the Service.</li>
  <li><strong>Brevo</strong> (email delivery), which receives recipient email addresses and message content for service emails.</li>
  <li><strong>Google</strong>, for Google Login and Google Analytics.</li>
  <li><strong>Google Fonts</strong>, which serve fonts to your browser on some pages.</li>
  <li><strong>Authorities or other parties</strong> where required by law, court order or to protect rights, safety and the security of the Service.</li>
  <li><strong>A successor</strong> if Hishabiz is involved in a merger, acquisition or sale of assets, in which case this Policy will continue to apply to your information unless you are told otherwise.</li>
</ul>
<p>Your own customers and suppliers are not given access to your data by us. If you share an invoice or message with them, you control that sharing.</p>

<h2 id="payments">7. Subscriptions and payments</h2>
<p>Hishabiz offers a free plan and paid plans with different limits and features. The Service does not currently process card or mobile-banking payments inside the application, and we do not store payment card or mobile-wallet credentials in the application. If you pay for a plan through another channel arranged with us, we will keep the records needed to manage your subscription and meet accounting obligations.</p>
<p>"Payments" and "dues" that appear inside Hishabiz are records you enter about money between your business, customers and suppliers. Hishabiz does not collect or transfer that money.</p>

<h2 id="retention">8. Retention and deletion</h2>
<ul>
  <li>We keep your account and business records while your account is active so that you can use the Service.</li>
  <li>Verification codes and password-reset tokens expire quickly. Unfinished Google sign-ups are kept for up to 14 days.</li>
  <li>The Service does not currently have a self-service "delete my account" button. To request deletion of your account and business data, or correction of your information, email us at the address in section 13. We will verify that the request comes from the account owner before acting.</li>
  <li>We may keep limited information after deletion where needed for legal, accounting, security or dispute-resolution purposes. Data held in backups may persist until those backups are overwritten.</li>
</ul>

<h2 id="rights">9. Your rights and responsibilities</h2>
<p>You may ask us to access, correct, export or delete the personal information we hold about you, or to object to certain uses, by contacting us. We will respond as required by applicable law, including the laws of Bangladesh.</p>
<p>You are responsible for:</p>
<ul>
  <li>the accuracy and legality of the records you enter;</li>
  <li>having the right to record personal information about your customers, suppliers and employees, and handling it lawfully;</li>
  <li>keeping your login details secure and managing the access you give to employees.</li>
</ul>

<h2 id="cookies">10. Cookies and sessions</h2>
<p>We use cookies and similar technologies to operate the Service:</p>
<ul>
  <li><strong>Session cookie</strong>: keeps you signed in and protects forms against cross-site request forgery (a security token cookie is used for the same purpose). Sessions are long-lived, so you may stay signed in on a device until you log out or the session expires.</li>
  <li><strong>"Remember me" cookie</strong>: set only if you choose "Remember me" at login.</li>
  <li><strong>Language cookie</strong>: remembers whether you prefer Bangla or English.</li>
  <li><strong>Analytics cookies</strong>: set by Google Analytics as described above.</li>
</ul>
<p>You can block or delete cookies in your browser settings, but the Service may not work properly without the session cookies. You can opt out of Google Analytics using Google's <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">browser add-on</a>.</p>

<h2 id="children">11. Children's privacy</h2>
<p>The Service is intended for business use by adults. It is not directed at children under 18, and we do not knowingly collect personal information from them. If you believe a child has provided us information, contact us and we will take steps to delete it.</p>

<h2 id="changes">12. Changes to this Policy</h2>
<p>We may update this Policy from time to time. The "Last updated" date at the top shows the latest version. If a change is significant, we will take reasonable steps to notify you, for example by email or a notice in the Service. Continued use after a change means you accept the updated Policy.</p>

<h2 id="contact">13. Contact us</h2>
<p>For privacy questions or requests:</p>
<ul>
  <li>Email: <a href="mailto:hishabiz.support@gmail.com">hishabiz.support@gmail.com</a></li>
  <li>WhatsApp: <a href="https://wa.me/8801577004929" target="_blank" rel="noopener">+880 1577 004929</a></li>
</ul>
@endsection
