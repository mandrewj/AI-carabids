import sys, requests, shutil, json, os
#import Image
print("This is working!!")
print(sys.argv)
print(len(sys.argv))
path = "/var/www/html/AI-carabids"
file_name="/var/www/html/AI-carabids/temp-img"

def parse_url(url):
    # Perform your URL parsing logic here
    # For example, you can fetch the content of the URL using a library like requests
    # and extract relevant information

    # For demonstration purposes, let's just return a modified version of the input URL
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
    model = load_model(os.path.join(path,'models','five_species.tf'))
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
    return(json.dumps(dwc_det, indent=2))
    



if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python3 parse.py <url>")
        sys.exit(1)
    
    imgurl = sys.argv[1]
    res = requests.get(imgurl, stream = True)
    if res.status_code != 200:
    	print("Url seems invalid")
    	sys.exit(1)
    with open(file_name, 'wb') as f:
    	shutil.copyfileobj(res.raw, f)
#    img = Image.open(file_name)
#    if img.format.lower() not in ['jpg', 'jpeg']:
#    	print("Image not in jpg format")
#    	sys.exit(1)
    
    parsed_result = parse_url(imgurl)
    print(parsed_result)
