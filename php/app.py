from flask import Flask, request, jsonify
from flask_cors import CORS  # Import CORS
import google.generativeai as genai

# Configure the Generative AI
genai.configure(api_key="AIzaSyCYWZ7RJbefP7KWE1pVwy5H_EYfVPTIGdM")
model = genai.GenerativeModel("gemini-1.5-flash")

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

@app.route('/generate', methods=['POST'])
def generate():
    data = request.json
    prompt = data.get("prompt", "")

    try:
        response = model.generate_content(prompt)
        return jsonify({"response": response.text})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True)
