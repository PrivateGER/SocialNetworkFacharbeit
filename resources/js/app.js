/*jslint node: true */
"use strict";

require('./bootstrap');

import App from "./components/App.svelte";

const app = new App({
    target: document.body
});

window.app = app;

window.API_ROUTES = {
    "login": "/api/auth/login",
    "tokeninfo": "/api/auth/info?token=",
    "changepassword": "/api/auth/changepassword",
    "logout": "/api/auth/logout",

    "post": "/api/post/view/",
    "createpost": "/api/post/create",
};

function checkAuth() {
	if(window.location.href.includes("login")) {
		return;
	}

	if(localStorage.getItem("token") === null || localStorage.getItem("token").length !== 128) {
		window.location.href = "/login";
		return;
	}

	fetch("/api/auth/info?token=" + localStorage.getItem("token"))
		.then((data) => {
			if(data.status === 401 && !window.location.href.includes("login")) {
				window.location.href = "/login";
			}
		});
}

window.permissionLevelToRole = (id) => {
	switch (id) {
		case 0:
			return "Ausgeschlossen";
		case 1:
			return "Benutzer";
		case 2:
			return "Vertrauter";
		case 3:
			return "Schülermod";
		case 4:
			return "Moderator";
		case 5:
			return "Administrator";
		case 6:
			return "Leitung";
		default:
			return "Unbekannt";
	}
};

export function findGETParameter(parameterName) {
	let result = null,
		tmp = [];
	location.search
		.substr(1)
		.split("&")
		.forEach(function (item) {
			tmp = item.split("=");
			if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
		});
	return result;
};

window.addEventListener("DOMContentLoaded", (event) => {
	checkAuth();
	setInterval(checkAuth, 2000);
});

function fallbackCopyTextToClipboard(text) {
	var textArea = document.createElement("textarea");
	textArea.value = text;
	textArea.style.position="fixed";  //avoid scrolling to bottom
	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();

	try {
		var successful = document.execCommand('copy');
		var msg = successful ? 'successful' : 'unsuccessful';
		console.log('Fallback: Copying text command was ' + msg);
	} catch (err) {
		console.error('Fallback: Oops, unable to copy', err);
	}

	document.body.removeChild(textArea);
}

export function copyTextToClipboard(text) {
	if (!navigator.clipboard) {
		fallbackCopyTextToClipboard(text);
		return;
	}
	navigator.clipboard.writeText(text).then(function() {
		console.log('Async: Copying to clipboard was successful!');
	}, function(err) {
		console.error('Async: Could not copy text: ', err);
	});
}

export default app;

