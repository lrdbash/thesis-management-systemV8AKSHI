<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Create Intake</title>
</head>
<style>
    /* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
    text-align: center;
    color: #333;
}

.intake-form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

.form-input {
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.submit-button {
    background-color: #007bff; /* Bootstrap Primary color */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #0056b3; /* Darker shade for hover */
}
</style>
<body>
    <div class="container">
        <h1 class="title">Create New Intake</h1>

        <form action="/admin/intakes/store" method="POST" class="intake-form">
            @csrf

            <label for="name">Intake Name:</label>
            <input type="text" name="name" required class="form-input">

            <div id="chapter-deadlines">
                <!-- Default chapters -->
                <div class="chapter-container" id="chapter-1">
                    <label>Chapter Name:</label>
                    <input type="text" name="chapters[0][name]" value="Chapter 1" required class="form-input">
                    <label for="chapters[0][deadline]">Deadline:</label>
                    <input type="date" name="chapters[0][deadline]" required class="form-input">
                </div>
                <div class="chapter-container" id="chapter-2">
                    <label>Chapter Name:</label>
                    <input type="text" name="chapters[1][name]" value="Chapter 2" required class="form-input">
                    <label for="chapters[1][deadline]">Deadline:</label>
                    <input type="date" name="chapters[1][deadline]" required class="form-input">
                </div>
            </div>

            <button type="button" class="add-button" id="add-chapter">Add Chapter</button>
            <button type="button" class="remove-button" id="remove-chapter">Remove Chapter</button>

            <label for="final_submission_deadline">Final Submission Deadline:</label>
            <input type="date" name="final_submission_deadline" required class="form-input">

            <label for="presentation_date">Presentation Date:</label>
            <input type="date" name="presentation_date" required class="form-input">

            <button type="submit" class="submit-button">Create Intake</button>
        </form>
    </div>

    <script>
        let chapterCount = 2; // Start with 2 chapters by default
        const maxChapters = 10; // Maximum chapters allowed

        document.getElementById('add-chapter').addEventListener('click', () => {
            if (chapterCount < maxChapters) {
                chapterCount++;
                const chapterContainer = document.createElement('div');
                chapterContainer.className = 'chapter-container';
                chapterContainer.id = `chapter-${chapterCount}`;
                chapterContainer.innerHTML = `
                    <label>Chapter Name:</label>
                    <input type="text" name="chapters[${chapterCount - 1}][name]" value="Chapter ${chapterCount}" required class="form-input">
                    <label for="chapters[${chapterCount - 1}][deadline]">Deadline:</label>
                    <input type="date" name="chapters[${chapterCount - 1}][deadline]" required class="form-input">
                `;
                document.getElementById('chapter-deadlines').appendChild(chapterContainer);
            } else {
                alert('Maximum 10 chapters allowed.');
            }
        });

        document.getElementById('remove-chapter').addEventListener('click', () => {
            if (chapterCount > 2) {
                const chapterContainer = document.getElementById(`chapter-${chapterCount}`);
                chapterContainer.remove();
                chapterCount--;
            } else {
                alert('At least 2 chapters are required.');
            }
        });
    </script>
</body>
</html>
