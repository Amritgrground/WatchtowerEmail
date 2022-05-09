let graphClient = undefined;

function initializeGraphClient(msalClient, account, scopes)
{
    // Create an authentication provider
    const authProvider = new MSGraphAuthCodeMSALBrowserAuthProvider
        .AuthCodeMSALBrowserAuthenticationProvider(msalClient, {
            account: account,
            scopes: scopes,
            interactionType: msal.InteractionType.PopUp
        });

    // Initialize the Graph client
    graphClient = MicrosoftGraph.Client.initWithMiddleware({authProvider});
}

async function getUser() {
    return graphClient
        .api('/me')
        // Only get the fields used by the app
        .select('id,displayName,mail,userPrincipalName,mailboxSettings')
        .get();
}