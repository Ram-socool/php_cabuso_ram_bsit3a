<!DOCTYPE html>
<html>
<head>
    <title>Peys App</title>
    <style>
        .photo-container {
            margin-top: 20px;
            text-align: left;
        }
        .photo {
            border-style: solid;
            display: inline-block;
            border-width: 5px;
        }
    </style>
</head>
<body>

    <h1>Peys App</h1>
    <form id="settingsForm" method="POST" action="javascript:void(0);">
        <label for="photo_size">Select Photo Size:</label>
        <input type="range" id="photo_size" name="photo_size" min="10" max="100" step="10" value="60">
        <span id="size_label">60</span>px<br><br>

        <label for="border_color">Select Border Color:</label>
        <input type="color" id="border_color" name="border_color" value="#000000"><br><br>

        <button type="button" onclick="updatePhotoSettings()">Apply Settings</button>
    </form>

    <div class="photo-container">
        <img src="picture.JPG" alt="Photo" id="photo" class="photo" style="width: 60px; height: 60px; border-color: #000000;">
    </div>

    <script>
        // Function to update photo settings
        function updatePhotoSettings() {
            const size = document.getElementById('photo_size').value;
            const color = document.getElementById('border_color').value;
            const photo = document.getElementById('photo');

            // Apply selected settings to the photo
            photo.style.width = `${size}px`;
            photo.style.height = `${size}px`;
            photo.style.borderColor = color;

            // Update size label
            document.getElementById('size_label').textContent = size;
        }
    </script>
    
</body>
</html>
