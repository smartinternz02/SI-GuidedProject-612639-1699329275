from flask import Flask, render_template, request, redirect, url_for, flash
import requests
import numpy as np
import pickle

model = pickle.load(open('model.pkl','rb'))
app = Flask(__name__)
app.secret_key = '123'
# Replace with the base URL of your PHP server
PHP_SERVER_URL = 'http://localhost:3000'

@app.route('/')
def index():
    return render_template('index.html')
@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

        # Redirect to PHP for login validation
        response = requests.post(f'{PHP_SERVER_URL}/login.php', data={'email': email, 'password': password})

        # No need to process the result here since the redirection is done in login.php

    return redirect(f'{PHP_SERVER_URL}/login.php')

@app.route('/handle_php_response')
def handle_php_response():
    login_success = request.args.get('login_success')

    if login_success == 'true':
        # Handle successful login
        flash('Login successful', 'success')
        return redirect(url_for('home'))
    else:
        # Handle login failure
        flash('Wrong email/pass', 'error')
        return redirect(url_for('login'))


@app.route('/home')
def home():
    return render_template('Home.html')

@app.route('/team')
def team():
    return render_template('Team.html')

@app.route('/calculator')
def calculator():
    return render_template('calculator.html')

@app.route('/predict', methods=['POST'])
def predict():
    col=['itching', 'continuous_sneezing', 'shivering', 'joint_pain',
        'stomach_pain', 'vomiting', 'fatigue', 'weight_loss', 'restlessness',
        'lethargy', 'high_fever', 'headache', 'dark_urine', 'nausea',
        'pain_behind_the_eyes', 'constipation', 'abdominal_pain', 'diarrhoea',
        'mild_fever', 'yellowing_of_eyes', 'malaise', 'phlegm', 'congestion',
        'chest_pain', 'fast_heart_rate', 'neck_pain', 'dizziness',
        'puffy_face_and_eyes', 'knee_pain', 'muscle_weakness',
        'passage_of_gases', 'irritability', 'muscle_pain', 'belly_pain',
        'abnormal_menstruation', 'increased_appetite', 'lack_of_concentration',
        'visual_disturbances', 'receiving_blood_transfusion', 'coma',
        'history_of_alcohol_consumption', 'blood_in_sputum', 'palpitations',
        'inflammatory_nails', 'yellow_crust_ooze']
    if request.method=='POST':
        inputt = [str(x) for x in request.form.values()]

        b=[0]*45
        for x in range(0,45):
            for y in inputt:
                if(col[x]==y):
                    b[x]=1
        b=np.array(b)
        b=b.reshape(1,45)
        prediction = model.predict(b)
        prediction = prediction[0]
        print(b)
    return render_template('results.html', prediction_text="Our diagnosis: {}".format(prediction))


if __name__ == '__main__':
    app.secret_key = 'your_secret_key'
    app.run(debug=True)
