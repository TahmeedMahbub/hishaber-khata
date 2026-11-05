# Google Login Setup for Hishabiz

This guide explains the Google Login setup completed so far for
**Hishabiz**.

## 1. Create a Google Cloud Project

1.  Open [Google Cloud Console](https://console.cloud.google.com/).
2.  Create a project named **Hishabiz**.
3.  Select the Hishabiz project before configuring Google Login.

## 2. Configure App Branding

1.  Open [Google Auth Platform --
    Branding](https://console.cloud.google.com/auth/branding).
2.  Set the app name to **Hishabiz**.
3.  Add the user support email.
4.  Add the Hishabiz logo.
5.  Set the application home page to `https://hishabiz.com`.
6.  Add the Privacy Policy and Terms of Service URLs, if available.
7.  Add `hishabiz.com` as an authorized domain.
8.  Add the developer contact email.
9.  Save the configuration.

## 3. Set the Audience

1.  Open **Google Auth Platform → Audience**.
2.  Set the user type to **External**.
3.  Keep the app in **Testing** mode while developing.
4.  Save the configuration.

> In Testing mode, only added test users can use Google Login. Google
> currently shows a limit of 100 test users before verification.

## 4. Create an OAuth Client

1.  Open **Google Auth Platform → Clients**.

2.  Click **Create Client**.

3.  Select **Web application** as the application type.

4.  Set the client name to `Hishabiz Web`.

5.  Add this Authorized JavaScript origin:

    `https://hishabiz.com`

6.  Add this Authorized redirect URI:

    `https://hishabiz.com/auth/google/callback`

7.  Create the OAuth client.

8.  Save the generated **Client ID** and **Client Secret** securely.

## 5. Add a Test User

1.  Open **Google Auth Platform → Audience**.
2.  Find the **Test users** section.
3.  Click **Add users**.
4.  Add the Gmail account that will be used for testing.
5.  Save the changes.

## 6. Add OAuth Credentials to Laravel

Add these variables to the Hishabiz Laravel project's `.env` file:

``` env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://hishabiz.com/auth/google/callback
```

Replace the example values with the credentials from Google Cloud
Console.

**Security notes:** - Never commit `.env` to Git. - Never put the Client
Secret in frontend code. - Do not share the Client Secret in
screenshots, chat messages, or public documents. - Keep the Client
Secret on the server only.

## 7. Laravel Implementation

The next development task is to implement Google Login in the Laravel
application.

The implementation should:

1.  Inspect the existing login, registration, user and business/tenant
    flows.
2.  Install and configure Laravel Socialite if it is not already
    installed.
3.  Add a Google Login button to the existing login and registration
    pages.
4.  Add the Google redirect and callback routes.
5.  Handle existing users and new users safely.
6.  Prevent duplicate accounts for the same verified email.
7.  Preserve Hishabiz's business/tenant data separation.
8.  Keep the existing email/password login working.
9.  Test successful login, registration, cancelled login and error
    cases.

Do not assume that Google OAuth setup alone completes the Laravel
integration. The application code still needs to be implemented and
tested.

## 8. Testing and Publishing

1.  Test Google Login using an email added under **Test users**.
2.  Confirm that existing users can sign in safely.
3.  Confirm that new users follow the normal Hishabiz
    registration/business setup flow.
4.  Confirm that one business cannot access another business's data.
5.  Keep the app in Testing mode until the integration is ready.
6.  Before public launch, complete the required Google Auth Platform
    configuration and verification steps, then publish the app.

## Current Progress

  Task                                        Status
  ------------------------------------------- ----------------------
  Google Cloud project created                Done
  Branding configured and saved               Done
  Audience set to External                    Done
  OAuth Web Client created                    Done
  Redirect URI configured                     Done
  Test user added                             Done
  OAuth credentials added to Laravel `.env`   Done, as reported
  Laravel Socialite integration               Pending confirmation
  Google Login tested in Hishabiz             Pending
  App published for public use                Pending

## Important URLs

-   [Google Cloud Console](https://console.cloud.google.com/)
-   [Google Auth Platform --
    Branding](https://console.cloud.google.com/auth/branding)
-   [Google Auth Platform --
    Audience](https://console.cloud.google.com/auth/audience)
-   [Google Auth Platform --
    Clients](https://console.cloud.google.com/auth/clients)
-   [Google OAuth Web Server
    Documentation](https://developers.google.com/identity/protocols/oauth2/web-server)
