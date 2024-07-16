function logoutUser() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        window.location.href = 'login.php';
      } else {
        console.error('Error logging out: ' + xhr.responseText);
      }
    }
  };
  xhr.open('POST', 'chat.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('action=logout');
}

function scrollToBottom() {
    var messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function displayMessage(message, username) {
    var messagesContainer = document.getElementById('messages-container');
    var messageDiv = document.createElement('div');
    var usernameText = document.createTextNode(username + "    " + new Date().toLocaleTimeString());
    var messageText = document.createTextNode(message);
    var newline = document.createElement("br");

    messageDiv.className = 'message-right'; // Adjust this as needed

    messageDiv.appendChild(usernameText);
    messageDiv.appendChild(newline);
    messageDiv.appendChild(messageText);

    messagesContainer.appendChild(messageDiv);
    scrollToBottom();
}



function fetchMessages() {
    fetch('chatmsg.php')
        .then(response => {if (response.status === 401) {
            // If 401 Unauthorized response received, redirect to login.php
            alert('Session expired, redirecting to login.');
            window.location.href = 'login.php';
            return;
        }
        return response.json();
        })
        .then(messages => {
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = ''; 
            const oneHourAgo = Date.now() - (60 * 60 * 1000);
            
            const recentMessages = messages.filter(message => {
                return (message.time * 1000) >= oneHourAgo;
            });

            for (let message of recentMessages) {
                const date = new Date(message.time * 1000);
                const formattedTime = date.toLocaleTimeString('en-US', {
                    hour12: false, 
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });

                const messageDiv = document.createElement('div');
                const usernameText = document.createTextNode(message.person + "    " + formattedTime);
                const messageText = document.createTextNode(message.message);
                const newline = document.createElement("br");
            
                if (message.person === currentUsername) { // assuming currentUsername is defined elsewhere
                    messageDiv.className = 'message-right';
                } else {
                    messageDiv.className = 'message-left';
                }

                messageDiv.appendChild(usernameText);
                messageDiv.appendChild(newline);
                messageDiv.appendChild(messageText);
            
                messagesContainer.appendChild(messageDiv);
                scrollToBottom();
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
}

function resetIdleTime() {
    idleTime = 0;
}

function timerIncrement() {
    idleTime++;
    if (idleTime >= idleTimeout) {
        alert("Login out from the session due to inactivity")
        logoutUser();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('chatroom-form');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var messageInput = document.getElementById('chatroom-input');
        var message = messageInput.value.trim();
        
        if (message) {
            // Send AJAX POST request
            fetch('chatmsg.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'message=' + encodeURIComponent(message)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    resetIdleTime();
                    displayMessage(message, currentUsername);
                } 
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
        }
    });
});

window.onload = function() {
    fetchMessages();
    setInterval(fetchMessages, 5000);
};


var idleTime = 0;
var idleTimeout = 120;

setInterval(timerIncrement, 1000);

