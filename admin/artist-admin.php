
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Artist</title>
</head>
<body>
    <div id="form-container">
        <form id="artist-form">
            <label for="artist-name">Name:</label>
            <input type="text" id="artist-name" name="name">

            <label for="artist-illustration">Illustration:</label>
            <input type="text" id="artist-illustration" name="illustration">

            <label for="artist-art-en">Art (EN):</label>
            <input type="text" id="artist-art-en" name="art-en">

            <label for="artist-art-fr">Art (FR):</label>
            <input type="text" id="artist-art-fr" name="art-fr">

            <label for="artist-art-nl">Art (NL):</label>
            <input type="text" id="artist-art-nl" name="art-nl">

            <label for="artist-link-name">Link Name:</label>
            <input type="text" id="artist-link-name" name="link-name">

            <label for="artist-link-url">Link URL:</label>
            <input type="text" id="artist-link-url" name="link-url">

            <button type="button" id="save-button">Save</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
