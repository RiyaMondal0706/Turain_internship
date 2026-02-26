<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Design</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --turain-purple: #4B0082;
            --turain-pink: #E91E63;
            --turain-blue: #00BCD4;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .id-card {
            width: 300px;
            height: 550px;
            top: 10px;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-bg {
            height: 220px;
            background: linear-gradient(135deg, #301091 0%, #6228d7 100%);
            border-bottom-left-radius: 50% 20%;
            border-bottom-right-radius: 50% 20%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
            /* IMPORTANT */
        }

        .pink-accent {
            position: absolute;
            top: 210px;
            right: -20px;
            width: 110%;
            height: 60px;
            background: var(--turain-pink);
            transform: rotate(-15deg);
            z-index: 1;
        }

        .blue-accent {
            position: absolute;
            top: 150px;
            right: 0;
            width: 150px;
            height: 250px;
            background: var(--turain-blue);
            clip-path: polygon(100% 0, 0% 100%, 100% 100%);
            z-index: 0;
        }

        /* PROFILE IMAGE CENTER */
        .profile-img-container {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 8px solid white;
            overflow: hidden;
            background: #80deea;
            z-index: 5;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* LOGO LEFT */
        .logo-box {
            position: absolute;
            top: 180px;
            left: 20px;
        }

        .card-body {
            padding: 25px 20px;
            position: relative;
            z-index: 10;
        }

        .name-title h2 {
            font-weight: 800;
            font-size: 22px;
            margin: 0;
            font-family: 'Lobster', sans-serif;
            text-transform: uppercase;
        }

        .name-title p {
            color: #666;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            border-bottom: 1px dotted #ccc;
            padding: 8px 0;
            font-size: 14px;
        }

        .info-label {
            width: 130px;
            font-weight: 600;
            color: #555;
        }

        .footer-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #444;
        }

        .qr-code {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 60px;
        }
    </style>
</head>

<body>

    <!-- ID CARD -->
    <div class="id-card" id="idCard">

        <div class="header-bg">

            <!-- LOGO LEFT -->


            <!-- PROFILE CENTER -->
            <div class="profile-img-container">
                <img src="{{ asset('assets/images/intern/' . $intern->image) }}" crossorigin="anonymous" alt="Profile">
            </div>

            <div class="logo-box">
                <img src="{{ asset('assets/images/logo.jpg') }}" style="height: 60px; width: 60px;">
            </div>
        </div>

        <div class="pink-accent"></div>
        <div class="blue-accent"></div>

        <div class="card-body">

            <div class="name-title">
                <h2>{{ $intern->name }}</h2>
                @php
                    $designation = DB::table('designations')->where('id', $intern->designation)->first();
                @endphp
                <p style = "color:black">{{ $designation->designation_name }}</p>
            </div>

            <div class="info-row">
                <div class="info-label">Employee ID</div>
                <div>{{ strtoupper($id->turain_id) }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Blood Group</div>
                <div>: O+</div>
            </div>

            <div class="info-row">
                <div class="info-label">Office Phone</div>
                <div>: +91 62903 84889</div>
            </div>

            <div class="footer-link">www.turaingrp.com</div>

            <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=TURAIN066" crossorigin="anonymous"
                class="qr-code" alt="QR">
        </div>
    </div>

    <!-- DOWNLOAD BUTTON -->
    <button class="btn btn-primary mt-4" onclick="downloadIdCard()">
        Download ID Card
    </button>

    <!-- PDF SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function downloadIdCard() {
            const card = document.getElementById('idCard');

            html2canvas(card, {
                scale: 3, // increase resolution for sharp image
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {

                const imgData = canvas.toDataURL('image/png');
                const {
                    jsPDF
                } = window.jspdf;

                // A4 size in pixels at 96dpi approx
                const pdfWidth = 300;
                const pdfHeight = 400;

                // calculate aspect ratio of card
                const cardWidth = canvas.width;
                const cardHeight = canvas.height;
                const ratio = Math.min(pdfWidth / cardWidth, pdfHeight / cardHeight);

                // calculate centered position
                const imgWidth = cardWidth * ratio;
                const imgHeight = cardHeight * ratio;
                const x = (pdfWidth - imgWidth) / 2;
                const y = (pdfHeight - imgHeight) / 2;

                const pdf = new jsPDF('portrait', 'pt', 'a4');

                pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
                pdf.save('ID_Card.pdf');
            });
        }
    </script>

</body>

</html>
