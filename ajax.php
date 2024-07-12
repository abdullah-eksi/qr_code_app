<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qrContent = isset($_POST['qrContent']) ? $_POST['qrContent'] : '';
    $qrColor = isset($_POST['qrColor']) ? $_POST['qrColor'] : '';
    $qrShape = isset($_POST['qrShape']) ? $_POST['qrShape'] : 'square';
    $qrBgColor = isset($_POST['qrBgColor']) ? $_POST['qrBgColor'] : '';
    $logo = isset($_FILES['qrLogo']) ? $_FILES['qrLogo'] : null;
    $qrCornerGradient = isset($_POST['qrCornerGradient']) ? $_POST['qrCornerGradient'] : '';
    $qrGradient = isset($_POST['qrGradient']) ? $_POST['qrGradient'] : '';
    $qrCornerGradient = explode(',', $qrCornerGradient);
    $qrGradient = explode(',', $qrGradient);
    $background_status = isset($_POST['background_status']) ? $_POST['background_status'] : '';
    $gradient_status = isset($_POST['gradient_status']) ? $_POST['gradient_status'] : '';

    if ($background_status==true) {
        $qrBgColor = "#f5f5f500";
    }


    if ($logo) {
        // Resim yüklemesi yapıldıysa devam et
        $targetDir = "cache_image/";
        $targetFilePath = $targetDir . uniqid() . '.' . pathinfo($logo['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($logo['tmp_name'], $targetFilePath)) {
            // QR kod oluşturma işlemi
            $uniq = uniqid();
?>
            <div style="display: flex; align-items:center;justify-content:center;" id="canvas<?php echo $uniq; ?>"></div>
            <?php

            if ($gradient_status == true) {


            ?>
                <script type="text/javascript">
                    const qrCode<?php echo $uniq; ?> = new QRCodeStyling({
                        width: 300,
                        height: 300,
                        type: "png",
                        data: "<?php echo $qrContent; ?>",
                        image: "<?php echo $targetFilePath; ?>",
                        dotsOptions: {
                            type: "<?php echo $qrShape;?>",
                            gradient: {
                                type: "linear",
                                rotation: 0,
                                colorStops: [{
                                    offset: 0,
                                    color: '<?php echo $qrGradient[0]; ?>'
                                }, {
                                    offset: 1,
                                    color: '<?php echo $qrGradient[1]; ?>'
                                }]
                            },
                        },
                        cornersSquareOptions: {
                            type: "<?php echo $qrShape;?>",
                            gradient: {
                                type: "linear",
                                rotation: 0,
                                colorStops: [{
                                    offset: 0,
                                    color: '<?php echo $qrCornerGradient[0]; ?>'
                                }, {
                                    offset: 1,
                                    color: '<?php echo $qrCornerGradient[1]; ?>'
                                }]
                            },
                        },
                        backgroundOptions: {
                            color: "<?php echo $qrBgColor; ?>",
                        },
                        imageOptions: {
                            crossOrigin: "anonymous",
                            margin: 5
                        }
                    });

                    qrCode<?php echo $uniq; ?>.append(document.getElementById("canvas<?php echo $uniq; ?>"));
                 function download_qr() {    
                    qrCode<?php echo $uniq; ?>.download({
                        name: "<?php echo $uniq; ?>",
                        extension: "png"
                    });
                }
                </script>
            <?php
            } else { ?>
                <script type="text/javascript">
                    const qrCode<?php echo $uniq; ?> = new QRCodeStyling({
                        width: 300,
                        height: 300,
                        type: "png",
                        data: "<?php echo $qrContent; ?>",
                        image: "<?php echo $targetFilePath; ?>",
                        dotsOptions: {
                            type: "<?php echo $qrShape;?>",
                            color: "<?php echo $qrColor; ?>",
                        },
                        cornersSquareOptions: {
                            type: "<?php echo $qrShape;?>",
                            color: "<?php echo $qrColor; ?>",
                        },
                        backgroundOptions: {
                            color: "<?php echo $qrBgColor; ?>",
                        },
                        imageOptions: {
                            crossOrigin: "anonymous",
                            margin: 5
                        }
                    });

                    qrCode<?php echo $uniq; ?>.append(document.getElementById("canvas<?php echo $uniq; ?>"));

                      function download_qr() {    
                    qrCode<?php echo $uniq; ?>.download({
                        name: "<?php echo $uniq; ?>",
                        extension: "png"
                    });
                }
                </script>



<?php }
        }
    } else {
        echo 'Resim yüklenirken bir hata oluştu.';
    }
} else {
    echo 'QR logo dosyası yüklenmedi.';
}

?>