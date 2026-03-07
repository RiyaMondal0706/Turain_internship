<!DOCTYPE html>
<html>

<head>
    <title>Internship Certificate</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
        }

        .certificate {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
            background: white;
            border: 10px solid #2f3d8f;
            position: relative;
        }

        .top-bar {
            text-align: right;
            font-size: 18px;
        }

        .logo {
            font-size: 40px;
            margin: 20px 0;
        }

        .title {
            font-size: 48px;
            letter-spacing: 8px;
            color: #2f3d8f;
            margin: 0;
        }

        .subtitle {
            color: #e91e63;
            margin-top: 5px;
        }

        .text {
            margin-top: 20px;
            font-size: 18px;
        }

        .name {
            font-size: 36px;
            font-family: cursive;
            color: #1c3b75;
        }

        .desc {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.6;
        }

        .bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 60px;
        }

        .sign {
            text-align: center;
        }

        .line {
            width: 200px;
            border-top: 2px solid #000;
            margin-bottom: 5px;
        }

        .qr img {
            width: 120px;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
        }

        .no-print {
            text-align: center;
            margin: 30px;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }
    </style>
</head>

<body>

    <div id="certificate" class="certificate">

        <div class="top-bar">
            <span>Sl No. <b>TSPL/INTRN/103/25-26</b></span>
        </div>

        <div class="logo">
            ⭐⭐⭐⭐
        </div>

        <h1 class="title">CERTIFICATE</h1>
        <h2 class="subtitle">OF INTERNSHIP</h2>

        <p class="text">This internship program certificate is proudly awarded to</p>

        <h2 class="name">{{ $candidate->name }}</h2>

        <p class="desc">
            For his outstanding completion of the internship program at firm
            <b>Turain Software Pvt. Ltd.</b> for the role of
            <b>{{ $candidate->designation }}</b>
            under the guidance of <b>Mr. Ayan Das</b>
            from date
            <b>{{ \Carbon\Carbon::parse($candidate->entry_date)->format('jS F, Y') }}</b>
            to
            <b>{{ \Carbon\Carbon::parse($candidate->end_date)->format('jS F, Y') }}</b>
        </p>

        <p class="desc">
            He is found to be hardworking, sincere and diligent.
        </p>

        <p class="desc">
            We wish him all the best for future.
        </p>

        <div class="bottom">

            <div class="sign">
                <div class="line"></div>
                HR Manager
            </div>

            <div class="qr">
                <img crossorigin="anonymous"
                    src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ url('/certificate/' . $candidate->id) }}">
            </div>

            <div class="sign">
                <div class="line"></div>
                Technical Head
            </div>

        </div>

        <div class="footer">
            <p>Turain Software Pvt. Ltd.</p>
            <p>CIN No : U64100WB2021PTC245220</p>
            <p>www.turaingrp.com | hr@turaingrp.com</p>
        </div>

    </div>

    <div class="no-print">
        <button onclick="downloadPDF()">Download Certificate</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function downloadPDF() {

            const element = document.getElementById('certificate');

            const opt = {
                margin: 0,
                filename: 'internship_certificate.pdf',
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 2,
                    useCORS: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save();

        }
    </script>

</body>

</html>
