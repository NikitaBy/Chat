(function () {
    let
        user = null,
        chatRoom = null,
        webSocket = null,
        session = null;

    const TYPE='received';

    window.webSocketChat = {
        init: init
    };

    function init() {
        // user = webSocketConfig.user;
        // chatRoom = webSocketConfig.chatRoom;
        connect();
    }

    webSocket = WS.connect("ws://127.0.0.1:8080");
    function connect() {
        webSocket.on("socket/disconnect", function (error) {
            //error provides us with some insight into the disconnection: error.reason and error.code
            console.log("Disconnected for " + error.reason + " with code " + error.code);
        });
    }

    webSocket.on("socket/connect", function (_session) {
        session = _session;

        session.subscribe("chat/habrchat", function (uri, payload) {
            let ul = document.getElementById("chat-list");
            let li = document.createElement("li");
            li.appendChild(document.createTextNode(payload.usr));
            li.appendChild(document.createTextNode(" sent:"));
            li.appendChild(document.createTextNode(payload.msg));
            ul.appendChild(li);

            console.log(payload);
        });

        session.publish("chat/habrchat", "Привет, я пришел от клиента!!!");
    });

    document.getElementById("form-submit").addEventListener("click", function () {
        let msg = document.getElementById("form-message").value;

        if (msg) {
            session.publish('chat/habrchat', msg);
            document.getElementById("form-message").value = "";
        }
    });
})();

