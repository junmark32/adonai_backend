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

  <style type='text/css'>
    body {
      margin: 0;
      background-color: silver;
    }
    #WebARRocksFaceCanvas, #threeCanvas {
      position: fixed;
      height: 100vh;
      top: 0;
      left: 50%;
      transform: rotateY(180deg) translate(50%, 0px);
    }

    #WebARRocksFaceCanvas {
      z-index: 0;
    }
    #threeCanvas {
      z-index: 1;
    }

    #controls {
      display: none;
      position: fixed;
      z-index: 2;
      width: 100vw;
      bottom: 0;
      left: 0;
      flex-direction: row;
      flex-wrap: wrap;
    }

    #controls > div {
      cursor: pointer;
      flex-grow: 1;
      font-variant: small-caps;
      font-size: 14pt;
      text-align: center;
      min-width: 110px;
      box-sizing: border-box;
      padding-top: 10px;
      background: rgba(0, 0, 0, 0.5);
      height: 40px;
      color: #eee;
    }

    #controls > div:hover {
      background: rgba(50, 50, 50, 0.5);
      color: #fff;
    }
  </style>
</head>
  
<body>
  <canvas id='WebARRocksFaceCanvas'></canvas>
  <canvas id='threeCanvas'></canvas>

  <div id='controls'>
    <div onclick='WebARRocksMirror.load("<?= base_url('assets/models3D/glasses1.glb')?>")'>Glasses 1</div>
    <div onclick='WebARRocksMirror.load("<?= base_url('assets/models3D/qwe.glb')?>")'>Glasses 2</div>
    <div onclick='WebARRocksMirror.load(false)'>No glasses</div>
    <div onclick='WebARRocksMirror.pause(true)'>Pause</div>
    <div onclick='WebARRocksMirror.resume(true)'>Resume</div>
    <div onclick='WebARRocksMirror.resize(400, 400)'>Resize</div>
    <div onclick='capture_image()'>Capture</div>
  </div>

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
  </script>
</body>
</html>
