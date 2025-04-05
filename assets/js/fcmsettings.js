importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js");
var config = {
	apiKey: "%APIKEY%",
	authDomain: "%AUTHDOMAIN%",
	databaseURL: "%DATABASEURL%",
	projectId: "%PROJECTID%",
	storageBucket: "%STRORAGEBUCKET%",
	messagingSenderId: "%MESSAGINGSENDERID%",
	appId: "%APPID%"
};

firebase.initializeApp(config);
notification = [];
icon = '';
base_url = '';
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  
    notification = JSON.parse(payload['data']['data']);
    icon = notification['icon'];
    base_url = notification['base_url'];
	
  if(notification['type'] == 'message'){

    var picture = notification['title'];
    var message = notification['body'];
	var from_id_fmc = notification['from_id'];
	
	
  

self.addEventListener('notificationclick', function(event) {
    
  event.waitUntil(self.clients.matchAll({
        includeUncontrolled: true, 
		type: 'window'
    }).then(function (clientList) {
        for (var i = 0; i < clientList.length; ++i) {
            var client = clientList[i];
			
            if ((client.url === base_url && 'focus' in client) 
			|| (client.url === base_url+'#' && 'focus' in client)
			|| (client.url === base_url+'/' && 'focus' in client)
			) {
				
				return client.focus();
            }
        }

        if (clients.openWindow) {
            return clients.openWindow(base_url);
        }
    }));
});
 