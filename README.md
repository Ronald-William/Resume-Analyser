📄 Resume Analyzer – OCR + Skill Matching Web App
A PHP-based web application that enables users to upload image files of resumes (JPG, PNG, etc.), extracts text using Tesseract OCR, matches relevant skills or keywords from a predefined XML database, and optionally emails the results to the user using PHPMailer. The frontend is styled using Tailwind CSS for a clean and responsive UI.

🚀 Features
📷 Image Upload
Users can upload resume images in formats like .jpg, .jpeg, .png, etc.

🧠 Text Extraction via OCR
Uses Tesseract OCR to extract raw text from the uploaded image.

🔍 Keyword Matching
Extracted text is matched against a list of predefined keywords/skills stored in an XML database.

📧 Email Notification
The matched skills and extracted content can be emailed to the user via PHPMailer.

🎨 Responsive UI
Interface built with Tailwind CSS for a minimal and modern design.

🛠️ Tech Stack
Technology	Purpose
PHP	Backend logic and file handling
Tesseract OCR	Extracts text from image files
Tailwind CSS	Responsive frontend design
XML	Stores and serves keyword database
PHPMailer	Sends email notifications

📦 Prerequisites and Dependencies
Before running the application, ensure the following dependencies are installed:

✅ Server Requirements
PHP ≥ 7.2

Apache / Nginx server with PHP support

Composer (for PHPMailer installation)

✅ PHP Extensions
gd (for image processing)

xml (for XML parsing)

mbstring (for string handling)

✅ Dependencies to Install
1. Tesseract OCR
2. PHPMailer

⚙️ How It Works
User uploads a resume image.

The server uses Tesseract OCR to extract the text.

Extracted text is parsed and matched against the XML-based skill list.

The final results are shown on screen or emailed using PHPMailer.

🤝 Contributions
Feel free to fork, raise issues, or suggest improvements. If you find this project helpful, give it a ⭐!

📜 License
This project is open-source and available under the MIT License.
