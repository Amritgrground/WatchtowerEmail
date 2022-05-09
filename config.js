const msalConfig = {
    auth: {
        clientId: '14ac12d4-e427-4665-ab54-96a8ce84d465',
        redirectUri: 'http://localhost:8080'
    }
};

const msalRequest = {
    scopes: [
        'user.read',
        'mailboxsettings.read',
        'calendars.readwrite'
    ]
}