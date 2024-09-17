const cache = {};


const chatToggle = document.getElementById('chat-toggle');
const chatWidget = document.getElementById("chat-widget");
const chatContainer = document.getElementById("chat-container");
const chatMessages = document.getElementById("chat-messages");
const chatInput = document.getElementById("chat-input");
const chatSendButton = document.getElementById("chat-send");

let chatVisible = false;
let introMessageSent = false;

chatToggle.addEventListener('click', () => {
chatVisible = !chatVisible;
chatWidget.classList.toggle('visible', chatVisible);
chatToggle.innerText = chatVisible ? 'Close' : 'Open Chat';
});

chatInput.addEventListener('keydown', (event) => {
if (event.key === 'Enter') {
event.preventDefault();
const userInput = chatInput.value.trim();
if (userInput) {
addChatMessage("You", userInput);
sendChatMessage(userInput);
chatInput.value = "";
}
}
});

chatSendButton.addEventListener("click", () => {
const userInput = chatInput.value.trim();
if (userInput) {
addChatMessage("You", userInput);
sendChatMessage(userInput);
chatInput.value = "";
}
});

function addChatMessage(sender, message) {
const messageContainer = document.createElement("div");
messageContainer.classList.add("chat-message-container");
const messageHeader = document.createElement("div");
messageHeader.classList.add("chat-message-header");
messageHeader.textContent = sender + ":";
const messageBody = document.createElement("div");
messageBody.classList.add("chat-message-body");
messageBody.textContent = message;
messageContainer.appendChild(messageHeader);
messageContainer.appendChild(messageBody);
chatMessages.appendChild(messageContainer);
chatContainer.scrollTop = chatContainer.scrollHeight;
}

// const { exec } = require('child_process');

function sendChatMessage(message) {
  if (!introMessageSent) {
    addChatMessage("Chat AI", "Hello! I'm Chat AI. I'm constantly improving and for that reason, from time to time I may not provide a very accurate answer! Please enter your message below.");
    introMessageSent = true;
  }

  const loadingElement = document.getElementById("loading");
  loadingElement.style.display = "block";



  const data = {
    message: message
};

  const serverIpAddress = '127.0.0.1'; // Reemplaza con la dirección IP de tu servidor Flask
  const serverPort = 5000; // Reemplaza con el puerto en el que se está ejecutando tu servidor Flask

  fetch(`http://${serverIpAddress}:${serverPort}/chat`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((data) => {
      const chatbotResponse = data.respuesta.trim();
      addChatMessage("Chat IA", chatbotResponse);
      loadingElement.style.display = "none";
    })
    .catch((error) => {
      console.error(error);
      addChatMessage("Chat IA", "Sorry, I was unable to process your request.");
      loadingElement.style.display = "none";
    });

}
