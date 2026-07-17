import { initializeApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'

const firebaseConfig = {
    apiKey: 'AIzaSyCWlSf0tQEqIUeCuG5upS-Z6UbTlEsf1pc',
    authDomain: 'serhii-cc780.firebaseapp.com',
    databaseURL:
        'https://serhii-cc780-default-rtdb.europe-west1.firebasedatabase.app',
    projectId: 'serhii-cc780',
    storageBucket: 'serhii-cc780.appspot.com',
    messagingSenderId: '929831572941',
    appId: '1:929831572941:web:9c41ca9a6d2440075ba084',
}

const app = initializeApp(firebaseConfig)

export const auth = getAuth(app)
