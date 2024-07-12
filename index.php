<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Kod Oluşturma Sitesi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <a href="#" class="text-white text-xl font-bold">QR Code App</a>
                <div>
                    <!-- Diğer navbar öğeleri buraya eklenebilir -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <header style="background-image: url('/assets/image/back.png');background-size:cover;background-repeat:no-repeat;" class="bg-blue-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold">QR Kodunuzu Kolayca Oluşturun</h1>
            <p class="mt-4">Özelleştirilebilir QR kodlarınızı hızlıca oluşturun ve paylaşın</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto py-8">
        <div class="bg-white p-8 rounded shadow-md w-full max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">QR Kod Oluşturma Formu</h2>
            <form id="qrForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="qrLogo" class="block text-gray-700 font-bold mb-2">Logo:</label>
                    <input type="hidden" id="hidden_path" name="hidden_path">
                    <input type="file" id="qrLogo" name="qrLogo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                </div>
                <div class="mb-4">
                    <label for="qrContent" class="block text-gray-700 font-bold mb-2">QR Kod İçeriği:</label>
                    <input type="text" id="qrContent" name="qrContent" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="qrColor" class="block text-gray-700 font-bold mb-2" >QR Kod Rengi:</label>
                    <input type="color" id="qrColor" name="qrColor" class="w-full h-10">
                </div>
           
             
                <div class="mb-4">
                    <input type="checkbox"  name="gradient_status" id="gradient_status"> Gradient Kullan
                </div>
                <div class="mb-4" id="qrGradientInput">
                    <label for="qrGradient" class="block text-gray-700 font-bold mb-2">QR Gradient:</label>
                    <input type="color" id="qrGradient1" name="qrGradient1" class="w-50 h-10">
                    <input type="color" id="qrGradient2" name="qrGradient2" class="w-50 h-10">
                </div>
                <div class="mb-4" id="qrCornerGradientInput">
                    <label for="qrCornerGradient" class="block text-gray-700 font-bold mb-2">Köşe Gradient:</label>
                    <input type="color" id="qrCornerGradient1" name="qrCornerGradient1" class="w-50 h-10">
                    <input type="color" id="qrCornerGradient2" name="qrCornerGradient2" class="w-50 h-10">
                </div>
            

                <div class="mb-4">
                    <input type="checkbox" checked  name="background_status" id="background_status"> Transparan Arkaplan
                </div>
                <div class="mb-4" id="qrBgColorInput">
                    <label for="qrBgColor" class="block text-gray-700 font-bold mb-2">QR Kod Arkaplan Rengi:</label>
                    <input type="color" id="qrBgColor" name="qrBgColor" class="w-full h-10">
                </div>
                <div class="mb-4">
                    <label for="qrShape" class="block text-gray-700 font-bold mb-2">QR Kod Şekli:</label>
                    <select id="qrShape" name="qrShape" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="square">Square</option>
                                <option value="dots">Dots</option>
                                <option value="rounded">Rounded</option>
                                <option value="extra-rounded" selected="">Extra rounded</option>
                                <option value="classy">Classy</option>
                                <option value="classy-rounded">Classy rounded</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="button" id="submitBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Oluştur</button>
                    <button type="button" onclick="download_qr();" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">İndir</button>
                 
                </div>
            </form>
            <div id="qrCodeContainer" class="mt-8"></div>
        </div>
    </main>

    <script>
        


         $('#qrBgColorInput').hide();
         $('#qrCornerGradientInput').hide();
         $('#qrGradientInput').hide();
        $(document).ready(function() {
            // Checkbox change events
            $('#background_status').change(function() {
                if ($(this).prop('checked')) {
                    $('#qrBgColorInput').hide();
                } else {
                    $('#qrBgColorInput').show();
                }
            });

            $('#gradient_status').change(function() {
                if ($(this).prop('checked')) {
                    $('#qrCornerGradientInput').show();
                    $('#qrGradientInput').show();
                    $('#qrColor').hide(); // Hide qrColorInput when gradient is checked
                } else {
                    $('#qrCornerGradientInput').hide();
                    $('#qrGradientInput').hide();
                    $('#qrColor').show(); // Show qrColorInput when gradient is not checked
                }
            });

            $('#qrLogo').change(function() {
                var fileData = new FormData();
                fileData.append('qrLogo', $('#qrLogo')[0].files[0]);
                
                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: fileData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#hidden_path').val(response.path);
                        } else {
                            alert('Logo yüklenirken bir hata oluştu: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Logo yüklenirken bir hata oluştu.');
                    }
                });
            });

            $('#submitBtn').click(function() {
                var formData = new FormData($('#qrForm')[0]);

                // Checkboxes status
                var background_status = $('#background_status').prop('checked') ? 1 : 0;
                var gradient_status = $('#gradient_status').prop('checked') ? 1 : 0;
                
                formData.append('background_status', background_status);
                formData.append('gradient_status', gradient_status);

                var qrCornerGradient = $('#qrCornerGradient1').val() + ',' + $('#qrCornerGradient2').val();
                var qrGradient = $('#qrGradient1').val() + ',' + $('#qrGradient2').val();

                formData.append('uploadedPath', $('#hidden_path').val());
                formData.append('qrCornerGradient', qrCornerGradient);
                formData.append('qrGradient', qrGradient);
                
                $('#qrCodeContainer').empty();
                
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'html',
                    success: function(response) {
                        $('#qrCodeContainer').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('QR kod oluşturulurken bir hata oluştu.');
                    }
                });
            });
        });
    </script>

</body>
</html>
