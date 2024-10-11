<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="content-language" content="en-EN" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />

  <title>WebAR.rocks Face Glasses VTO Demo</title>
  
  <!-- INCLUDE WebAR.rocks.face MAIN SCRIPT -->
  <script src="<?= base_url('dist/WebARRocksFace.js')?>"></script>
  
  <!-- INCLUDE MAIN HELPER -->
  <script src="<?= base_url('helpers/WebARRocksFaceThreeHelper.js')?>"></script>

  <!-- THREE.JS, FOR THE RENDERING -->
  <script src="<?= base_url('libs/three/v136/build/three.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/loaders/GLTFLoader.js')?>"></script>

  <!-- THREE.JS RGBE loader - you can remove it if you don't use envmap: -->
  <script src="<?= base_url('libs/three/v136/examples/js/loaders/RGBELoader.js')?>"></script>

  <!-- THREE.JS postprocessing - you can remove it if you don't use bloom or temporal anti aliasing : -->
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/EffectComposer.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/ShaderPass.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/RenderPass.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/shaders/CopyShader.js')?>"></script>

  <!-- Bloom postprocessing: -->
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/UnrealBloomPassTweaked.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/shaders/LuminosityHighPassShader.js')?>"></script>
  
  <!-- TAA specifics: -->
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/SSAARenderPass.js')?>"></script>
  <script src="<?= base_url('libs/three/v136/examples/js/postprocessing/TAARenderPass.js')?>"></script>

  <!-- INCLUDE MIRROR HELPER -->
  <script src="<?= base_url('helpers/WebARRocksMirror.js')?>"></script>

  <!-- INCLUDE MAIN DEMO SCRIPT -->
  <script src="<?= base_url('dist/main.js')?>"></script>

  <!-- INCLUDE LANDMARKS STABILIZER -->
  <script src="<?= base_url('helpers/landmarksStabilizers/OneEuroLMStabilizer.js')?>"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style type='text/css'>
     * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #000;
            color: white;
        }

        #cameraContainer {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: black;
}

@media (min-width: 768px) {
    #cameraContainer {
        width: 375px; /* Set fixed mobile width */
        height: 667px; /* Set fixed mobile height (iPhone X height) */
        margin: 0 auto; /* Center the container on larger screens */
    }
}

canvas {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    transform: scaleX(-1); /* Flip horizontally */
    
}



        /* Floating controls like Instagram */
        #controls {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 2;
        }

        #captureBtn {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            border: 5px solid #888;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #filtersMenu {
            position: absolute;
            bottom: 120px;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 2;
        }

        .filter-option {
            margin: 0 10px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .filter-option img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Floating icons on top */
        .top-controls {
            position: absolute;
            top: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }

        .top-controls div {
            background-color: rgba(255, 255, 255, 0.3);
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
  </style>
</head>
<body>

<div id="cameraContainer">
    <canvas id='WebARRocksFaceCanvas'></canvas>
    <canvas id='threeCanvas'></canvas>

    <!-- Top control buttons -->
    <div class="top-controls">
        <div onclick='switchCamera()'>Switch Camera</div>
        <div onclick='WebARRocksMirror.load(false)'>No Glasses</div>
    </div>

    <!-- Filter selection -->
    <div id="filtersMenu">
        <div class="filter-option" onclick='WebARRocksMirror.load("<?= base_url('assets/models3D/glasses1.glb')?>")'>
            <img src="filter1-thumbnail.jpg" alt="Filter 1">
        </div>
        <div class="filter-option" onclick='WebARRocksMirror.load("<?= base_url('assets/models3D/qwe.glb')?>")'>
            <img src="filter2-thumbnail.jpg" alt="Filter 2">
        </div>
    </div>

    <!-- Capture button -->
    <div id="controls">
        <div id="captureBtn" onclick="capture_image()"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faceCanvas = document.getElementById('WebARRocksFaceCanvas');
        const threeCanvas = document.getElementById('threeCanvas');

        if (faceCanvas && threeCanvas) {
            console.log('Canvas elements found');
            
            // Initialize WebARRocksFace
            WebARRocksFace.initialize({
                canvas: faceCanvas,
                onSuccess: function() {
                    console.log('WebARRocksFace initialized successfully');
                },
                onError: function(error) {
                    console.error('WebARRocksFace initialization error:', error);
                }
            });

            // Initialize THREE.js
            const renderer = new THREE.WebGLRenderer({ canvas: threeCanvas });
            renderer.setSize(window.innerWidth, window.innerHeight);
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

            // Add additional THREE.js setup here
        } else {
            console.error('Canvas elements not found');
        }
    });

    function capture_image() {
        // Implement image capture logic here
        console.log('Capture button clicked');
    }

    function switchCamera() {
        // Switch camera function
        console.log('Switch camera clicked');
    }
</script>

</body>
</html>
