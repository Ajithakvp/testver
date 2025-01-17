<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href=
"https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <title>File Upload with Progress Bar</title>
</head>

<style>
    
body {
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(to right,
                        #3494E6, #EC6EAD);
    height: 100vh;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #f4f4f4;
}

.card {
    text-align: center;
    padding: 20px;
    border: 2px solid #faa301;
    border-radius: 10px;
    max-width: 500px;
    width: 100%;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.app-title {
    color: #27ae60;
}

.app-subtitle {
    color: #333;
}

.file-label {
    cursor: pointer;
    display: flexbox;
    padding: 7px;
    background-color: #c834db;
    color: #fff;
    border-radius: 8px;
    margin-bottom: 60px;
    transition: background-color 0.3s;
}

.file-label:hover {
    background-color: #73ec10;
}

.file-input {
    display: none;
}

.progress-container {
    margin-top: 15px;
    position: relative;
    height: 20px;
}

.progress-bar {
    width: 0;
    height: 100%;
    background-color: #2ecc71;
    border-radius: 5px;
    transition: width 0.3s;
}

.progress-text {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    color: #333;
    font-size: 14px;
    display: none;
}

.file-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.file-name {
    color: rgb(19, 2, 255);
}

.clear-button {
    padding: 5px 12px;
    background-color: #e74c3c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    display: none;
}

.clear-button:hover {
    background-color: #c0392b;
}

.preview-container img {
    max-width: 100%;
    max-height: 150px;
    cursor: pointer;
    margin-top: 15px;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 80%;
    max-height: 80%;
}

.close {
    color: #fff;
    font-size: 35px;
    font-weight: bold;
    position: absolute;
    top: 15px;
    right: 25px;
    cursor: pointer;
}
</style>

<body>
    <div class="card">
        <h1 class="app-title">
            <i class="fas fa-file-upload"></i>
        </h1>
        <h3 class="app-subtitle">
              File Upload with Progress Bar
          </h3>
        <label for="fileInput" class="file-label">
            <i class="fas fa-cloud-upload-alt"></i> 
          Choose a file
        </label>
        <input type="file" id="fileInput" class="file-input" />
        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
            <div class="progress-text" id="progressText"></div>
        </div>
        <div class="file-details">
            <div class="file-name" id="fileName"></div>
            <button class="clear-button" id="clearButton">
                <i class="fas fa-times"></i>
                Clear
            </button>
        </div>
        <div class="preview-container" id="previewContainer"></div>
    </div>
    <div class="modal" id="myModal">
        <span class="close" id="closeModal">&times;</span>
        <img class="modal-content" id="uploadedImageModal">
    </div>
    <script >
        document.addEventListener('DOMContentLoaded', () => {
            const fInput = document.getElementById('fileInput');
            const pBar = document.getElementById('progressBar');
            const pText = document.getElementById('progressText');
            const fName = document.getElementById('fileName');
            const modal = document.getElementById('myModal');
            const cModal = document.getElementById('closeModal');
            const uImage = document.getElementById('uploadedImageModal');
            const pContainer = document.getElementById('previewContainer');
            const cBtn = document.getElementById('clearButton');
            fInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
               
                    const reader = new FileReader();
                    reader.onloadstart = () => {
                        pBar.style.width = '0%';
                        pText.style.display = 'block';
                        pText.innerText = '0%';
                        pContainer.style.display = 'none';
                        cBtn.style.display = 'none';
                    };
                    reader.onprogress = (event) => {
                        if (event.lengthComputable) {
                            const progress = 
                                (event.loaded / event.total) * 100;
                            pBar.style.width = `${progress}%`;
                            pText.innerText = `${Math.round(progress)}%`;
                        }
                    };
                    reader.onload = () => {
                        const uploadTime = 4000;
                        const interval = 50;
                        const steps = uploadTime / interval;
                        let currentStep = 0;
                        const updateProgress = () => {
                            const progress = (currentStep / steps) * 100;
                            pBar.style.width = `${progress}%`;
                            pText.innerText = `${Math.round(progress)}%`;
                            currentStep++;
        
                            if (currentStep <= steps) {
                                setTimeout(updateProgress, interval);
                            } else {
                                pBar.style.width = '100%';
                                pText.innerText = '100%';
                                fName.innerText = `File Name: ${file.name}`;
                                pContainer.innerHTML = 
                                    `<img src="${reader.result}" 
                                          alt="Preview" id="previewImage">`;
                                pContainer.style.display = 'block';
                                cBtn.style.display = 'block';
                            }
                        };
                        setTimeout(updateProgress, interval);
                    };
                    
                    reader.readAsDataURL(file);
               
            });
            pContainer.addEventListener('click', () => {
                modal.style.display = 'block';
                uImage.src = document.getElementById('previewImage').src;
            });
            cModal.addEventListener('click', () => {
                modal.style.display = 'none';
            });
            cBtn.addEventListener('click', () => {
                fInput.value = '';
                pBar.style.width = '0%';
                pText.style.display = 'none';
                fName.innerText = '';
                pContainer.style.display = 'none';
                cBtn.style.display = 'none';
            });
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>