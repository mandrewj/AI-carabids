#!/usr/bin/python3

import sys, requests, shutil, json, os
from PIL import Image

file_name="temp-img"
if len(sys.argv) > 1:
    imgurl = sys.argv[1]
    res = requests.get(imgurl, stream= True)
    if res.status_code == 200:
        with open(file_name, 'wb') as f:
            shutil.copyfileobj(res.raw, f)
        img = Image.open(file_name)
        if img.format.lower() in ['jpg', 'jpeg']:
            #print("now load and call model to test")
            #silence tensorflow
            from silence_tensorflow import silence_tensorflow
            silence_tensorflow()
            #code copied from AI jupyter notebook
            import tensorflow as tf
            import cv2, json
            import numpy as np
            from tensorflow.keras.models import load_model
            from datetime import date
            #update this path to the desired model
            model = load_model(os.path.join('models','five_species.tf'))
            #re-read image in, resize it per model expectations
            img = cv2.imread(file_name)
            resize = tf.image.resize(img, (400, 600))
            #add verbose=0 to silence Keras prediction
            y_prob = model.predict(np.expand_dims(resize/255, 0), verbose=0)
            y_classes = y_prob.argmax(axis=-1)
            #define class names - could make this programmatic in the future
            classes=('PASCAL','OMUDEJ','PASELO','PTELAM','SCASUB')
            #Create output and print it
            #print(f'Predicted taxon is: {classes[y_classes[0]]}')
            #create dictionary of dwc terms
            dwc_det = {
            	"scientificName" : classes[y_prob.argmax()],
                "identifiedBy" : "AI model for carabids by M.A. Johnston",
                "dateIdentified" : date.today().strftime("%Y-%m-%d"),
                "identificationReferences" : "ID used the five_species carabid model",
                "identificationRemarks" : f'Model probability is {y_prob[0][y_prob.argmax()]}'
            }
            print(json.dumps(dwc_det, indent=2))

        else:
            print("image not in jpg format")
    else:
        print('Image URL appears invalid')
else:
    print("No input URL given")