from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
from flask_socketio import SocketIO, join_room, leave_room, send
import google.generativeai as genai
from PIL import Image
import io
import pytesseract
import secrets
from dotenv import load_dotenv
import os

# Load environment variables from .env file
load_dotenv()
pytesseract.pytesseract.tesseract_cmd = r"C:\Program Files\Tesseract-OCR\tesseract.exe"

# Configure the Generative AI
api_key = os.getenv("GENERATIVE_AI_API_KEY")
genai.configure(api_key=api_key)
model = genai.GenerativeModel("gemini-1.5-flash")

app = Flask(__name__)
app.config['SECRET_KEY'] = secrets.token_hex(16)
socketio = SocketIO(app)
CORS(app)  # Enable CORS for all routes

# Hardcoded symptom-medication mapping
symptom_medication_mapping = {
    "headache": {"medication": "Ibuprofen", "description": "Pain reliever and anti-inflammatory."},
    "fever": {"medication": "Paracetamol", "description": "Used to reduce fever and relieve mild pain."},
    "cough": {"medication": "Dextromethorphan", "description": "Cough suppressant used for dry cough."},
    "cold": {"medication": "Cetirizine", "description": "Antihistamine for allergy relief."},
    "sore throat": {"medication": "Lozenges", "description": "Provides soothing relief for throat irritation."},
    "allergy": {"medication": "Loratadine", "description": "Antihistamine for allergy symptoms."},
    "nausea": {"medication": "Ondansetron", "description": "Prevents nausea and vomiting."},
    "vomiting": {"medication": "Metoclopramide", "description": "Treats nausea and vomiting."},
    "diarrhea": {"medication": "Loperamide", "description": "Slows down gut movement to treat diarrhea."},
    "constipation": {"medication": "Lactulose", "description": "A stool softener for constipation relief."},
    "stomach pain": {"medication": "Omeprazole", "description": "Reduces stomach acid to relieve pain."},
    "indigestion": {"medication": "Antacids", "description": "Neutralizes stomach acid for quick relief."},
    "acidity": {"medication": "Ranitidine", "description": "Reduces acid production in the stomach."},
    "asthma": {"medication": "Salbutamol", "description": "Relieves asthma symptoms by opening airways."},
    "arthritis": {"medication": "Diclofenac", "description": "Reduces pain and inflammation in joints."},
    "insomnia": {"medication": "Melatonin", "description": "Helps regulate sleep patterns."},
    "anxiety": {"medication": "Alprazolam", "description": "Reduces anxiety and promotes calmness."},
    "depression": {"medication": "Sertraline", "description": "An antidepressant for mood stabilization."},
    "hypertension": {"medication": "Amlodipine", "description": "Lowers blood pressure."},
    "diabetes": {"medication": "Metformin", "description": "Helps control blood sugar levels."},
    "cholesterol": {"medication": "Atorvastatin", "description": "Reduces bad cholesterol levels."},
    "flu": {"medication": "Oseltamivir", "description": "Antiviral for flu treatment."},
    "migraine": {"medication": "Sumatriptan", "description": "Relieves migraine headaches."},
    "muscle pain": {"medication": "Carisoprodol", "description": "Relieves muscle spasms and pain."},
    "skin rash": {"medication": "Hydrocortisone Cream", "description": "Reduces inflammation and itching."},
    "burns": {"medication": "Silver Sulfadiazine", "description": "Prevents infection in burns."},
    "eczema": {"medication": "Calamine Lotion", "description": "Soothes irritated skin and reduces itching."},
    "psoriasis": {"medication": "Coal Tar Ointment", "description": "Reduces scaling and itching in psoriasis."},
    "urinary tract infection": {"medication": "Nitrofurantoin", "description": "Treats bacterial infections of the urinary tract."},
    "back pain": {"medication": "Naproxen", "description": "Reduces inflammation and relieves pain."},
    "toothache": {"medication": "Clove Oil", "description": "Provides temporary relief for toothache."},
    "sinusitis": {"medication": "Pseudoephedrine", "description": "Relieves sinus congestion."},
    "eye irritation": {"medication": "Artificial Tears", "description": "Lubricates and soothes dry eyes."},
    "ear infection": {"medication": "Amoxicillin", "description": "Treats bacterial ear infections."},
    "heartburn": {"medication": "Esomeprazole", "description": "Reduces acid reflux and heartburn."},
    "fatigue": {"medication": "Vitamin B Complex", "description": "Boosts energy levels and reduces fatigue."},
    "weight loss": {"medication": "Orlistat", "description": "Aids in weight management."}
}

# Hardcoded symptom-diagnosis mapping
symptom_diagnosis_mapping = {
    "headache": "Possible causes include tension headaches, migraines, or sinusitis.",
    "fever": "Possible causes include infections such as the flu, common cold, or other viral or bacterial infections.",
    "cough": "Possible causes include common cold, flu, bronchitis, or asthma.",
    "cold": "Possible causes include viral infections such as the common cold or flu.",
    "sore throat": "Possible causes include viral infections, bacterial infections, or allergies.",
    "allergy": "Possible causes include exposure to allergens such as pollen, dust, or pet dander.",
    "nausea": "Possible causes include motion sickness, pregnancy, or gastrointestinal infections.",
    "vomiting": "Possible causes include food poisoning, gastrointestinal infections, or pregnancy.",
    "diarrhea": "Possible causes include food poisoning, gastrointestinal infections, or irritable bowel syndrome.",
    "constipation": "Possible causes include lack of fiber in the diet, dehydration, or certain medications.",
    "stomach pain": "Possible causes include indigestion, gastritis, or peptic ulcers.",
    "indigestion": "Possible causes include overeating, spicy foods, or stress.",
    "acidity": "Possible causes include gastroesophageal reflux disease (GERD) or spicy foods.",
    "asthma": "Possible causes include exposure to allergens, exercise, or respiratory infections.",
    "arthritis": "Possible causes include osteoarthritis, rheumatoid arthritis, or gout.",
    "insomnia": "Possible causes include stress, anxiety, or sleep disorders.",
    "anxiety": "Possible causes include stress, generalized anxiety disorder, or panic disorder.",
    "depression": "Possible causes include major depressive disorder, bipolar disorder, or seasonal affective disorder.",
    "hypertension": "Possible causes include high salt intake, obesity, or genetic factors.",
    "diabetes": "Possible causes include type 1 diabetes, type 2 diabetes, or gestational diabetes.",
    "cholesterol": "Possible causes include high cholesterol levels due to diet, genetics, or lack of exercise.",
    "flu": "Possible causes include influenza virus infection.",
    "migraine": "Possible causes include hormonal changes, certain foods, or stress.",
    "muscle pain": "Possible causes include muscle strain, overuse, or injury.",
    "skin rash": "Possible causes include allergic reactions, eczema, or infections.",
    "burns": "Possible causes include thermal burns, chemical burns, or electrical burns.",
    "eczema": "Possible causes include genetic factors, allergies, or irritants.",
    "psoriasis": "Possible causes include genetic factors or immune system dysfunction.",
    "urinary tract infection": "Possible causes include bacterial infections of the urinary tract.",
    "back pain": "Possible causes include muscle strain, herniated disc, or poor posture.",
    "toothache": "Possible causes include dental cavities, gum disease, or tooth infection.",
    "sinusitis": "Possible causes include viral infections, bacterial infections, or allergies.",
    "eye irritation": "Possible causes include dry eyes, allergies, or infections.",
    "ear infection": "Possible causes include bacterial or viral infections of the ear.",
    "heartburn": "Possible causes include gastroesophageal reflux disease (GERD) or spicy foods.",
    "fatigue": "Possible causes include lack of sleep, anemia, or chronic fatigue syndrome.",
    "weight loss": "Possible causes include diet, exercise, or medical conditions such as hyperthyroidism."
}

# Function to extract text from image using OCR
def extract_text_from_image(image):
    try:
        # Use pytesseract to extract text from the image
        text = pytesseract.image_to_string(image)
        return text
    except Exception as e:
        return str(e)

@app.route('/')
def index():
    return render_template('chat.php')

@app.route("/your-chatbot-endpoint", methods=["POST"])
def chatbot():
    data = request.json
    user_message = data.get("prompt", "")
    # Your chatbot logic here
    response = f"Hello! You said: {user_message}"
    return jsonify({"response": response})

@app.route('/generate', methods=['POST'])
def generate():
    data = request.json
    prompt = data.get("prompt", "").lower()
    print(f"Received prompt: {prompt}")  # Debugging: Print the received prompt

    # Check for hardcoded symptom-medication mappings
    for symptom in symptom_medication_mapping:
        if symptom in prompt:
            medication = symptom_medication_mapping[symptom]
            print(f"Found symptom for medication: {symptom}")  # Debugging: Print the found symptom
            return jsonify({
                "response": f"For {symptom}, the recommended medication is {medication['medication']}: {medication['description']}"
            })

    # Check for hardcoded symptom-diagnosis mappings
    for symptom in symptom_diagnosis_mapping:
        if symptom in prompt:
            diagnosis = symptom_diagnosis_mapping[symptom]
            print(f"Found symptom for diagnosis: {symptom}")  # Debugging: Print the found symptom
            return jsonify({
                "response": f"Based on your symptoms, {diagnosis}"
            })

    # Check for support group request
    if "join support group" in prompt:
        room = "support_group"
        link = f"http://127.0.0.1:5000/chat/{room}"
        return jsonify({
             "response": f'You can join the support group here: <a href="{link}" target="_blank">Join Support Group</a>'
        })

    print("No matching symptom found, using generative AI")  # Debugging: Print if no symptom is found
    try:
        response = model.generate_content(prompt)
        return jsonify({"response": response.text})
    except Exception as e:
        print(f"Error: {str(e)}")  # Debugging: Print the error
        return jsonify({"error": str(e)}), 500

@app.route('/upload', methods=['POST'])
def upload():
    if 'image' not in request.files:
        return jsonify({"error": "No image uploaded"}), 400

    image = request.files['image']
    image = Image.open(io.BytesIO(image.read()))

    # Extract text from the uploaded image using OCR
    extracted_text = extract_text_from_image(image)

    if not extracted_text:
        return jsonify({"error": "Failed to extract text from image"}), 400

    # Send the extracted text to the generative AI for explanation
    try:
        response = model.generate_content(extracted_text)
        return jsonify({"response": response.text})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/chat/<room>')
def chat(room):
    return render_template('chat.php', room=room)

@socketio.on('join')
def on_join(data):
    username = data['username']
    room = data['room']
    join_room(room)
    send(f'{username} has entered the room.', to=room)

@socketio.on('leave')
def on_leave(data):
    username = data['username']
    room = data['room']
    leave_room(room)
    send(f'{username} has left the room.', to=room)

@socketio.on('message')
def handle_message(data):
    room = data['room']
    username = data['username']
    message = data['message']
    send(f'{username}: {message}', to=room)

if __name__ == "__main__":
    socketio.run(app, debug=True)