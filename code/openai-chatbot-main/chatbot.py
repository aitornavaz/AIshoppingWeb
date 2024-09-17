
from flask import Flask, request, jsonify
from hugchat import hugchat
from hugchat.login import Login

from flask_cors import CORS  # Importa la extensión

app = Flask(__name__)
CORS(app, origins="http://localhost")  # Configura los orígenes permitidos

# Resto de tu código Flask


# Inicializa el chatbot y los cookies una vez
passw = "Q@bLxUu$9WAQC7H"
email = "lopecillo845@gmail.com"

sign = Login(email, passw)
cookies = sign.login()

# Save cookies to the local directory
cookie_path_dir = "./cookies_snapshot"
sign.saveCookiesToDir(cookie_path_dir)
chatbot = hugchat.ChatBot(cookies=cookies.get_dict())
def preguntarChatbot(pregunta):
    print("Pregunta: ",pregunta)
    respuesta = str(chatbot.chat(pregunta))
    print(respuesta)
    return respuesta

@app.route('/chat', methods=['POST'])
def chat():
    data = request.get_json()
    pregunta = data['message']
    respuesta = preguntarChatbot(pregunta)
    return jsonify({'respuesta': respuesta})

if __name__ == "__main__":
    app.run(debug=True)
