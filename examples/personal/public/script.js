"use strict";

var elementId = "tokenAccessBtn";
var tokenController;
var button;

function clean() {
    if (button) {
        button.destroy();
        button = null;
    }

    if (tokenController && tokenController.destroy) {
        tokenController.destroy();
        tokenController = null;
    }
}

function createRedirectButton() {
    // clean up instances
    clean();

    // create TokenPopupController to handle Popup messages
    tokenController = window.Token.createRedirectController();

    // get button placeholder element
    var element = document.getElementById(elementId);

    // create the button
    button = window.Token.createTokenButton(element, {
        label: "Redirect Token Access",
    });

    // bind the Token Button to the Redirect Controller when ready
    tokenController.bindButtonClick(button, function(action) {
    // Each time the button is clicked, a new tokenRequestUrl is created
        getTokenRequestUrl(function(tokenRequestUrl) {
            // Initialize popup using the tokenRequestUrl
            action(tokenRequestUrl);
        });
    });
    // enable button after binding
    button.enable();
}

function createPopupButton() {
    // clean up instances
    clean();

    // create TokenPopupController to handle Popup messages
    tokenController = window.Token.createPopupController();

    // get button placeholder element
    var element = document.getElementById(elementId);

    // create the button
    button = window.Token.createTokenButton(element, {
        label: "Popup Token Access",
    });

    // setup onLoad callback
    tokenController.onLoad(function(controller) {
        // bind the Token Button to the Popup Controller when ready
        tokenController.bindButtonClick(button, function(action) {
            // Each time the button is clicked, a new tokenRequestUrl is created
            getTokenRequestUrl(function(tokenRequestUrl) {
                // Initialize popup using the tokenRequestUrl
                action(tokenRequestUrl);
            });
        });
        // enable button after binding
        button.enable();
    });

    // setup onSuccess callback
    tokenController.onSuccess(function(data) { // Success Callback
        // build success URL
        var successURL = "/fetch-balances"
           + "?tokenId=" + window.encodeURIComponent(data.tokenId);
        // navigate to success URL
        window.location.assign(successURL);
    });

    // setup onError callback
    tokenController.onError(function(error) { // Failure Callback
        throw error;
    });
}

function getTokenRequestUrl(done) {
    var XHR = new XMLHttpRequest();

    //set up the access request
    XHR.open("POST", "http://localhost:9090/request-balances", true);

    XHR.setRequestHeader("Content-Type", "application/json; charset=utf-8");

    var data = $.param({
        resources: [ // the button asks for permission to:
            { type: Token.RESOURCE_TYPE_ALL_ACCOUNTS }, // get list of accounts
            { type: Token.RESOURCE_TYPE_ALL_BALANCES }, // get balance of each account
        ]
     });

     // Define what happens on successful data submission
     XHR.addEventListener("load", function(event) {
         // execute callback once response is received
         if (event.target.status === 200) {
             done(event.target.responseURL);
         }
     });

    // Send the data; HTTP headers are set automatically
    XHR.send(data);
}

function setupButtonTypeSelector() {
    var selector = document.getElementsByName('buttonTypeSelector');
    var selected;
    for (var i = 0; i < selector.length; i++) {
        if (selector[i].checked) {
            selected = selector[i].value;
        }
        selector[i].addEventListener('click', function(e) {
            var value = e.target.value;
            if (value === selected) return;
            if (value === 'popup') {
                createPopupButton();
            } else if (value === 'redirect') {
                createRedirectButton();
            }
            selected = value;
        });
    }
    createPopupButton();
}

setupButtonTypeSelector();
